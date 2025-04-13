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
    $name  = $_SESSION['username'] ?? "N/A";
    $userinfo = match ($name) {
      "N/A" => <<<HTML
      <a href="../html/login.html">Login</a>
      <a href="../html/register.html">Daftar</a>
      HTML,
      default => <<<HTML
      <a href="../html/profil.html">Profil</a>
      HTML,
    };

    echo match($page) {
      "main" => <<<HTML
        <nav>
        <!--a href="../html/kategori.html">Kategori Donasi</a-->
        <a href="../html/kampanye.html">Kampanye</a>
        $userinfo
        <!--a href="../html/lokasi.html">Lokasi Bencana</a-->
        <a href="../html/company-profile.html">Company Profile</a>
      </nav>
      HTML,
      "profil" => <<<HTML
        <nav>
        <a href="../html/index.html">Beranda</a>
        <!--a href="../html/kategori.html">Kategori Donasi</a-->
        <a href="../html/kampanye.html">Kampanye</a>
        <a href="" hx-post="/api/logout">Logout</a>
        <!--a href="../html/lokasi.html">Lokasi Bencana</a-->
        <a href="../html/company-profile.html">Company Profile</a>
        </nav>
      HTML,
      "kampanye" => <<<HTML
        <nav>
        <a href="../html/index.html">Beranda</a>
        <!--a href="../html/kategori.html">Kategori Donasi</a-->
        $userinfo
        <!--a href="../html/lokasi.html">Lokasi Bencana</a-->
        <a href="../html/company-profile.html">Company Profile</a>
        </nav>
      HTML,
      default => <<<HTML
        <nav>
        <a href="../html/index.html">Beranda</a>
        <!--a href="../html/kategori.html">Kategori Donasi</a-->
        <a href="../html/kampanye.html">Kampanye</a>
        $userinfo
        <!--a href="../html/lokasi.html">Lokasi Bencana</a-->
        <a href="../html/company-profile.html">Company Profile</a>
        </nav>
      HTML,
    };
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
