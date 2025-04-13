<?php

namespace Bantoo\App\Database;

use \Bantoo\App\Utils\Log;
use PDOStatement;

final class Mysql {
  private static $dsn = "mysql:host=localhost;port=3306;dbname=bantoo;charset=UTF8";
  
  private static $username = "root";
  private static $password = "";
  
  private static $options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
  ];
  
  // Store the single instance
  private static ?Mysql $instance = null;
  
  // Database connection object
  private \PDO $connection;
  
  // Private constructor to prevent direct instantiation
  private function __construct() {
    $this->connection = new \PDO(Mysql::$dsn, MySql::$username, MySql::$password, Mysql::$options);
  }
  
  private function __clone() {
    throw new \Exception("Can't clone a singleton");
  }
  
  // The method to get the singleton instance
  public static function db(): ?Mysql {
    if (self::$instance === null) {
      $className = __CLASS__;
      self::$instance = new $className;
    }
    
    return self::$instance;
  }

  public function getCampaignData(bool $isAdmin, int $lastindex, int $pagesize): bool | PDOStatement {
    $allCampaignSql = <<<SQL
    with 
      active as (select c.* from all_campaigns c where rid > :lastindex limit :pagesize)
    select
      a.*, p.* 
    from 
      active a 
    inner join 
      campaign_progress p on p.pid = a.id
    SQL;

    $activeCampaignSql = <<<SQL
    with 
      active as (select c.* from active_campaigns c where rid > :lastindex limit :pagesize)
    select
      a.*, p.* 
    from 
      active a 
    inner join 
      campaign_progress p on p.pid = a.id
    SQL;
 
    $stmt = $this->connection->prepare($isAdmin ? $allCampaignSql : $activeCampaignSql);
    $stmt->execute(['lastindex' => $lastindex, 'pagesize' => $pagesize]);
    
    return $stmt;
  }

  public function getLatestCampaignData(): bool | PDOStatement {
    $sql = <<<SQL
    select * from active_campaigns_progress
    SQL;
    
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    
    return $stmt;
  }

  public function setStatus(int $id, string $status, string $newStatus): bool {
    $sql = <<<SQL
    update campaign set status = upper(:new_status) where id = :id and status = upper(:status)
    SQL;
    
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(['id' => $id, 'status' => $status, 'new_status' => $newStatus]);
    
    return $stmt->rowCount() > 0;
  }

  public function acceptDonation(int $campaign_id, object $donation): bool {
    $jumlah = (double)preg_replace("/[^.0-9]/", "", $donation->jumlah);
    $sql = <<<SQL
    insert into campaign_donation(campaign_id, donatur_id, amount, message) values (:campaign_id, :donatur_id, :amount, :message);
    SQL;

    return $this->connection
      ->prepare($sql)
      ->execute([
        'campaign_id' => $campaign_id,
        'donatur_id'  => $donation->donatur_id,
        'amount'      => $jumlah,
        'message'     => $donation->pesan,
      ]);
  }

  public function getUser($email, $password): bool | PDOStatement {
    $sql = <<<SQL
    select id, name, role from user where email = :email and password = :password
    SQL;

    $stmt = $this->connection->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password]);

    return $stmt;
  }

  public function registerUser(string $name, string $email, string $password, $photo): bool {
    $sql = <<<SQL
    insert into user (name, email, password, photo) values (:name, :email, :password, :photo)
    SQL;

    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':name',    $name);
    $stmt->bindParam(':email',   $email); 
    $stmt->bindParam(':password',$password);
    $stmt->bindParam(':photo',   $photo, \PDO::PARAM_LOB);

    return $stmt->execute();
  }

  public function getUserPhoto(int $id): bool|string {
    $sql = <<<SQL
    select photo from user where id = :id
    SQL;

    $stmt = $this->connection->prepare($sql);
    $stmt->execute([ 'id' => $id]);

    if ($stmt->rowCount() === 1) {
      $photo = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0]['photo'];
      return $photo === null ? false : $photo;
    };

    return false;
  }
}
