<?php

namespace Bantoo\App\Controller;

use \Bantoo\App\Database\Mysql;
use \Bantoo\App\Utils\Log;
use \Bantoo\App\Utils\Http;

final class User {
  public static function login(): void {
    $email = $_POST['email'] ?? 'N/A';
    $password = $_POST['password'] ?? 'N/A';
    Log::trace("Process user login $email");
    $stmt = Mysql::db()->getUser($email, $password);
    if ($stmt->rowCount() === 1) {
      $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      $_SESSION['useremail'] = $email;
      $_SESSION['username']  = $result[0]['name'];
      $_SESSION['userid']    = $result[0]['id'];
      $_SESSION['userrole']  = $result[0]['role'];
      
      Http::redirect_to('/html/index.html');
    }
    else {
      session_destroy();
      session_start();
      User::render();
    }
  }
  
  public static function logout(): void {
    session_destroy();
    Http::redirect_to('/html/index.html');
  }
  
  public static function register(): void {
    $name     = $_POST['registerName'] ?? "Dermawan Terhormat";
    $email    = $_POST['registerEmail'] ?? null;
    $password = $_POST['registerPassword'] ?? null;
    $photo    = fopen($_FILES['registerFoto']['tmp_name'], 'rb');
    
    Log::trace("Process user register $email");
    $result = Mysql::db()->registerUser($name, $email, $password, $photo);
    if ($result) {
      Http::redirect_to('/html/login.html');
    }
    else {
      Http::redirect_to('/html/register.html');     
    }
  }
  
  public static function profile(): void {
    $name  = $_SESSION['username'] ?? 'N/A';
    $email = $_SESSION['useremail'] ?? 'N/A';
    
    if ($name === 'N/A') {
      Http::redirect_to('/html/login.html');
    }
    else {
      $photo    = Mysql::db()->getUserPhoto($_SESSION['userid']);
      $photosrc = $photo ? "data:image/jpeg;base64," . base64_encode($photo) : "../foto/hayya.png";
      
      echo <<<HTML
      <section id="profil">
      <h2>Profil Pengguna</h2>
      <div class="profil-container">
      <img id="fotoProfil" src=$photosrc alt="Foto Profil" style="width: 100px; height: auto; border-radius: 8px;">
      <div class="profil-info">
      <p><strong>Nama:</strong> $name</p>
      <p><strong>Surel:</strong> $email</p>
      </div>
      </div>
      <div class="action">
      <button hx-post="/api/logout">Logout</button>
      </div>
      </section>
      HTML;
    };
  }
  
  public static function menu($page): void {
    Log::trace("Process navigation for page $page");
    $name  = $_SESSION['useremail'] ?? "N/A";
    $userinfo = match ($name) {
      "N/A" => <<<HTML
      <a href="../html/login.html">Login</a>
      <a href="../html/register.html">Daftar</a>
      HTML,
      default => <<<HTML
      <a href="../html/profil.html">Profil</a>
      <a href="" hx-get="/api/campaign/start" hx-target="#dialog" hx-swap="beforeend">Mulai Kampanye</a>
      <a href="" hx-post="/api/logout">Logout</a>
      HTML,
    };
    
    echo match($page) {
      "main" => <<<HTML
      <nav>
      <a href="../html/kampanye.html">Kampanye</a>
      <a href="../html/company-profile.html">Company Profile</a>
      $userinfo
      </nav>
      HTML,
      "profil" => <<<HTML
      <nav>
      <a href="../html/index.html">Beranda</a>
      <a href="../html/kampanye.html">Kampanye</a>
      <a href="../html/company-profile.html">Company Profile</a>
      <a href="" hx-post="/api/logout">Logout</a>
      </nav>
      HTML,
      "kampanye" => <<<HTML
      <nav>
      <a href="../html/index.html">Beranda</a>
      <a href="../html/company-profile.html">Company Profile</a>
      $userinfo
      </nav>
      HTML,
      default => <<<HTML
      <nav>
      <a href="../html/index.html">Beranda</a>
      <a href="../html/kampanye.html">Kampanye</a>
      <a href="../html/company-profile.html">Company Profile</a>
      $userinfo
      </nav>
      HTML,
    };
  }
  
  public static function createCampaign(): void {
    echo <<<HTML
    <div id="startCampaign" class="modal" _="on closeDialogCampaign add .closing then wait for animationend then remove me">
      <div class="modal-underlay" _="on click trigger closeDialogCampaign"></div>
        <div class="modal-content">
        <form id="formKampanye" enctype="multipart/form-data" hx-post="/api/campaign/start" hx-target="find .actionbar" _="on submit trigger hideActionBar">
          <div class="form-group">
            <label for="title">Nama Kampanye:</label>
            <input type="text" name="title" required>
          </div>
          <div class="form-group">
            <label for="description">Deskripsi:</label>
            <textarea name="description" required></textarea>
          </div>
          <div class="form-group">
            <label for="target">Target Donasi (Rp):</label>
            <input type="currency" name="target" pattern="IDR\s[0-9,]{3,}[.]{0,1}[0-9]{1,2}" required>
          </div>
          <div class="form-group">
            <label for="campaignPhoto">
              <img  id="campaign-photo" style="max-height:450px; width: auto; border-radius: 8px; cursor: pointer;" src="data:image/jpeg;base64,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" />
            </label>
            <input type="file" id="campaignPhoto" name="campaignPhoto" accept="image/jpeg" onchange="loadCampaignPhoto(event)" hidden>
            <script>
              var loadCampaignPhoto = function(event) {
                var file = event.target.files[0];
                if (['image/jpeg', 'image/jpg'].indexOf(file.type) < 0) return false;
                var reader = new FileReader();
                reader.onload = function() {
                  var output = document.getElementById('campaign-photo');
                  output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
              };
            </script>                    
          </div>
          <div class="action actionbar">
            <button type="submit" hx-indicator="next <img/>" _="on hideActionBar hide me">Mulai Kampanye</button>
            <img class="htmx-indicator"/>
          </div>
        </form>
        <script src="../js/currency.js"></script>
      </div>
    </div>
    HTML;
  }

  public static function registerCampaign(): void {
    Log::trace("Will register campaign");
    
    $campaign = (object)$_POST;

    $photo = fopen($_FILES['campaignPhoto']['tmp_name'], 'rb');
    $campaign->campaignPhoto = $photo; 

    Mysql::db()->registerCampaign($campaign);

    Log::trace("Campaign register, pending for review");

    echo <<<HTML
    <span>Kampanye anda menunggu review untuk disetujui</span>
    <script type="text/hyperscript">init wait 2s then trigger closeDialogCampaign on #startCampaign</script>
    HTML;
  }

  private static function render(): void {
    echo <<<HTML
    <div><p><strong>Username atau password salah!</strong></p></div>
    <form id="loginForm" hx-post="/api/login">
    <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Login</button>
    </form>
    HTML;
  }
}
