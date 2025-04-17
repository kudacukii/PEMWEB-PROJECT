<?php

namespace Bantoo\App\Controller;

use \Bantoo\App\Database\Mysql;
use \Bantoo\App\Utils\Log;

final class Campaign {
  public static function getCampaigns($lastindex, $pagesize): void {
    Log::trace("Render campaign from row id $lastindex for $pagesize rows");

    $campaign = new \stdClass();
    $campaign->lastindex    = $lastindex;
    $campaign->pagesize     = $pagesize;
    $campaign->isActive     = !Campaign::isAdmin();
    $campaign->maintainerId = Campaign::getCurrentUserId();
    $stmt = Mysql::db()->getCampaignData($campaign);

    if ($stmt->rowCount() > 0) {
      $lastindex += $pagesize;

      foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $campaign = (object)$row;
        Campaign::renderCampaign($campaign);
      }

      echo <<<HTML
      <span hx-get="/api/campaign/$lastindex/$pagesize" hx-trigger="revealed" hx-target="closest ul" hx-swap="beforeend swap:1s" _="on htmx:afterRequest wait 1s then remove me"><img src="../css/bars.svg"/> Loading...</span>
      HTML;
    }
    Log::trace("Render completed for row id $lastindex for $pagesize rows");
  }

  public static function getLatestCampaigns(): void {
    Log::trace("Render latest campaign");
    $stmt = Mysql::db()->getLatestCampaignData();

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
      Campaign::renderLatest((object)$row);
    }

    Log::trace("Render completed for latest campaign");
  }

  public static function approveCampaign(string $curStatus, int $id): void {
    Log::trace("Approve campaign : #$id");

    $isPending = $curStatus === "pending";
    $newStatus = "ongoing";

    if (Campaign::isAdmin() && $isPending) {
      Mysql::db()->setStatus($id, $curStatus, $newStatus);
    }

    echo Campaign::renderIntent($id, 0, $newStatus);
  }

  public static function rejectCampaign(string $curStatus, int $id): void {
    Log::trace("Reject campaign : #$id");

    $isPending = $curStatus === "pending";
    $newStatus = "rejected";

    if (Campaign::isAdmin() && $isPending) {
      Mysql::db()->setStatus($id, $curStatus, $newStatus);
    }

    echo Campaign::renderIntent($id, 0, $newStatus);
  }

  public static function closeCampaign(string $curStatus, int $id): void {
    Log::trace("Close campaign : #$id");

    $isOngoing = $curStatus === "ongoing";
    $newStatus = "completed";

    if (Campaign::isAdmin() && $isOngoing) {
      //TODO if set status failed reload whole li
      Mysql::db()->setStatus($id, $curStatus, $newStatus);
    }

    echo Campaign::renderIntent($id, 0, $newStatus);
  }

  public static function removeCampaign(string $curStatus, int $id): void {
    Log::trace("Remove campaign : #$id");

    $okDeleted = $curStatus === "completed" || $curStatus === 'rejected';

    if (Campaign::isAdmin() && $okDeleted) {
      Mysql::db()->deleteCampaign($id, $curStatus);
    }

    echo '';
  }

  public static function editCampaign(int $id) {
    $campaign = (object)Mysql::db()->getCampaign($id);
    echo <<<HTML
    <div id="editCampaign" class="modal" _="on closeDialogCampaign add .closing then wait for animationend then remove me">
      <div class="modal-underlay" _="on click trigger closeDialogCampaign"></div>
        <div class="modal-content">
        <form id="formKampanye" hx-post="/api/campaign/amend" hx-target="find .actionbar" _="on submit trigger hideActionBar">
          <input type="hidden" name="id" value="$id"/>
          <div class="form-group">
            <label for="title">Nama Kampanye:</label>
            <input type="text" name="title" value="$campaign->title" required>
          </div>
          <div class="form-group">
            <label for="description">Deskripsi:</label>
            <textarea name="description" required>$campaign->description</textarea>
          </div>
          <div class="form-group">
            <label for="target">Target Donasi (Rp):</label>
            <input type="currency" name="target" pattern="IDR\s[0-9,]{3,}[.]{0,1}[0-9]{1,2}" value="$campaign->target_donasi" required>
          </div>
          <div class="action actionbar">
            <button type="submit" hx-indicator="#loading" _="on hideActionBar hide me">Perbarui Kampanye</button>
            <img id="loading" class="htmx-indicator"/>
          </div>
        </form>
        <script src="../js/currency.js"></script>
      </div>
    </div>
    HTML;
  }

  public static function amendCampaign() {
    $campaign = (object)$_POST;

    Log::trace("Amend campaign : #$campaign->id");
    $message = Mysql::db()->amendCampaign($campaign) ? 'berhasil' : 'gagal'; 

    echo <<<HTML
    <span>Perubahan $message</span>
    <script type="text/hyperscript">init wait 2s then remove #campaign-$campaign->id then trigger closeDialogCampaign on #editCampaign</script>
    HTML;
  }

  public static function showDonation(int $id): void {
    Log::trace("Render Donation form for campaign #$id");

    $name      = $_SESSION['username'] ?? 'Dermawan Budiman';
    $email     = $_SESSION['useremail'] ?? 'dermawan@budiman';
    $userid    = $_SESSION['userid'] ?? "-1";
    $dialog_id = "dialog-donasi-$id";

    echo <<<HTML
    <div id="$dialog_id" class="modal" _="on closeDonation add .closing then wait for animationend then remove me">
      <div class="modal-underlay" _="on click trigger closeDonation"></div>
      <div class="modal-content">
        <form id="donasiForm" hx-post="/api/campaign/donate/$id" hx-target="find .actionbar" _="on submit trigger hideActionBar">
          <div class="form-group">
            <input type="text" name="donatur_id" value="$userid" hidden>
            <label for="nama">Nama Lengkap:</label>
            <input type="text" name="nama" value="$name" readonly>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" value="$email" readonly>
          </div>
          <div class="form-group">
            <label for="jumlah">Jumlah Donasi (Rp):</label>
            <input type="currency" name="jumlah" pattern="IDR\s[0-9,]{3,}[.]{0,1}[0-9]{1,2}" required>
          </div>
          <div class="form-group">
            <label for="pesan">Pesan (Opsional):</label>
            <textarea name="pesan" rows="2"></textarea>
          </div>
          <div class="action actionbar">
          <button type="submit" hx-indicator="next <img/>" _="on hideActionBar hide me">Donasi Sekarang</button>
          <img class="htmx-indicator"/>
          </div>
        </form>
        <script src="../js/currency.js"></script>  
      </div>
    </div>
    HTML;
  }

  public static function acceptDonation(int $id) {    
    Log::trace("Will accept donation form for campaign #$id");
    $donation = (object)$_POST;

    Mysql::db()->acceptDonation($id, $donation);

    Log::trace("Accept donation form for campaign #$id");

    echo <<<HTML
    <span>Terima kasih atas donasinya sebesar $donation->jumlah</span>
    <script type="text/hyperscript">init wait 2s then trigger closeDonation on #dialog-donasi-$id</script>
    HTML;
  }

  private static function renderCampaign(object $campaign): void{
    $status      = strtolower($campaign->status);
    $title       = ucwords(strtolower($campaign->title));
    $description = $campaign->description;
    $target      = number_format($campaign->target_donasi,2,",",".");
    $raised      = number_format($campaign->raised,2,",",".");
    $raised_pct  = number_format($campaign->raised_pct,0,",",".") . "%";
    $impressions = $campaign->impressions;
    $donatur     = $campaign->donatur;
    $mid         = $campaign->mid ?? 0;
    $intent      = Campaign::renderIntent($campaign->id, $mid, $status);
    $imgsrc      = Campaign::renderImg($campaign);

    echo <<<HTML
    <li id="campaign-$campaign->id">
      <div class="box">
        <div class="info">
          <img src="$imgsrc" style="width: 100px; height: auto; border-radius: 8px;"/>
          <span><strong>$title</strong></span>
          <span>$description</span>
          <span>Target: Rp. $target, Terkumpul: Rp. $raised, Prosentasi: $raised_pct</span>
          <span>Like: $impressions, Donatur: $donatur<span>
        </div>
        $intent
      </div>
    </li>
    HTML;
  }

  private static function renderLatest(object $campaign): void {
    $title          = ucwords(strtolower($campaign->title));
    $description    = $campaign->description;
    $target         = number_format($campaign->target_donasi,2,",",".");
    $raised         = number_format($campaign->raised,2,",",".");
    $raised_pct     = number_format($campaign->raised_pct,0,",",".") . "%";
    $impressions    = $campaign->impressions;
    $donatur        = $campaign->donatur;
    $imgsrc         = Campaign::renderImg($campaign);
    $donationButton = Campaign::renderDonationButton(Campaign::getCurrentRole(), $campaign->id);

    echo <<<HTML
    <div class="berita-item">
      <div class="campaign">
        <img src="$imgsrc" alt="$title">
        <h3>$title</h3>
        <p>$description</p>
        Like: $impressions<br>
        Donatur: $donatur<br>
        Target: Rp. $target<br>
        Terkumpul: Rp. $raised<br>
        Prosentasi: $raised_pct<br>
      </div>
      <div class="campaign-action">
        $donationButton
      </div>
    </div>
    HTML;
  }

  private static function renderIntent(int $id, int $mid, string $status): string {
    $campaign = new \stdClass();
    $campaign->role   = Campaign::getCurrentRole();
    $campaign->id     = $id;
    $campaign->status = $status;
    $campaign->mid    = $mid;

    $intent    = "campaign-action-$id";
    $class     = "label $status";
    $label     = ucwords($status);

    $actionbar = match ($campaign->role) {
      'ADMIN' => match ($campaign->status) {
        'pending' => <<<HTML
        <button hx-patch="/api/campaign/reject/$status/$id" hx-target="#$intent" hx-swap="outerHTML">Tolak</button>
        <button hx-patch="/api/campaign/approve/$status/$id" hx-target="#$intent" hx-swap="outerHTML">Setujui</button>
        HTML,
        'ongoing' => <<<HTML
        <button hx-patch="/api/campaign/complete/$status/$id" hx-target="#$intent" hx-swap="outerHTML">Selesai</button>
        HTML,
        default => <<<HTML
        <button hx-patch="/api/campaign/remove/$status/$id" hx-target="#campaign-$id" hx-swap="outerHTML">Hapus</button>
        HTML,
      },
      'USERS' => match ($status) {
        'ongoing' => Campaign::renderUserButton($campaign),
        default   => '',
      },
      default => '',
    };

    return <<<HTML
    <div class="intent" id="$intent">
      <div class="$class"><p><strong>$label</strong></p></div>
      <br>
      <div class="action">$actionbar</div>
    </div>
    HTML;
  }

  private static function renderDonationButton(string $role, int $id): string {
    return match ($role) {
      'N/A' => 
        <<<HTML
        <button onclick="location.href='../html/login.html'">Donasi Sekarang</button>
        HTML,
      'USERS' =>
        <<<HTML
        <button hx-get="/api/campaign/donate/$id" hx-target="#dialog" hx-swap="beforeend">Donasi Sekarang</button>
        HTML,
      default => ''
    };
  }

  private static function renderUserButton(object $campaign): string {
    $editButton = ($campaign->mid > 0) ? 
    <<<HTML
    <button hx-get="/api/campaign/edit/$campaign->status/$campaign->id" hx-target="#dialog" hx-swap="beforeend">Edit Kampanye</button>
    HTML
    :
    ''
    ;
    return match ($campaign->role) {
      'N/A' => 
        <<<HTML
        <button onclick="location.href='../html/login.html'">Donasi Sekarang</button>
        HTML,
      'USERS' =>
        <<<HTML
        $editButton
        <button hx-get="/api/campaign/donate/$$campaign->id" hx-target="#dialog" hx-swap="beforeend">Donasi Sekarang</button>
        HTML,
      default => ''
    };
  }

  private static function renderImg(object $campaign): string {
    return ($campaign->photo === null || $campaign->content_type === null) ? "../foto/hayya.png" : "data:$campaign->content_type;base64," . base64_encode($campaign->photo);
  }

  private static function isAdmin(): bool {
    return Campaign::getCurrentRole() === 'ADMIN';
  }

  private static function getCurrentRole(): string {
    return $_SESSION['userrole'] ?? 'N/A';
  }

  private static function getCurrentUserId(): int {
    return (int)($_SESSION['userid'] ?? '-1');
  }
}
