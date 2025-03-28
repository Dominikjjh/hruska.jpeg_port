<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hruska.jpeg_portfolio</title>
    <head>
    <link rel="stylesheet" href="css/mobil.css">
    </head>

</head>
</head>
<head>
    <div class="header">Car Prague Festival</div>
    <div class="contact-info">
        <img src="icons/6929237_instagram_icon.png" alt="Instagram"> hruska.jpeg |
        <img src="icons/134146_mail_email_icon.png" alt="Email"> hruska.d07@seznam.cz |
        <img src="icons/8665646_phone_communication_icon.png" alt="Telefon"> 608848444
    </div>

    <div class="button-container">
    <button onclick="window.location.href='index.php'" class="nav-button">
        Hlavní stránka
    </button>

    <button onclick="openAlbumPopup()" class="nav-button">
        Alba
    </button>

    <button onclick="window.location.href='download_gallery.php?folder=fotky'" class="nav-button">
        Stáhnout galerii
    </button>
    </div>


    <div id="overlay" style="display: none;"></div>

    <!-- Popup okno pro výběr alba -->
    <div id="albumPopup" style="display: none;">
        <div class="popup-content">
            <span onclick="closeAlbumPopup()" class="close-btn">&times;</span>
            <h2>Vyber album:</h2>
            <button onclick="openAlbum('festival.php')">Festival</button>
            <button onclick="openAlbum('svatba.php')">Svatba</button>
            <button onclick="openAlbum('priroda.php')">Příroda</button>
            <button onclick="openAlbum('cipa.php')">Cipa</button>
            <button onclick="openAlbum('cipea.php')">Cipa</button>
            <button onclick="openAlbum('cieeepa.php')">Cipa</button>
            <button onclick="openAlbum('cipddsa.php')">Cipa</button>
            <button onclick="openAlbum('cipa.php')">Cipa</button>
            <button onclick="openAlbum('cipsa.php')">Cipa</button>
            <button onclick="openAlbum('cipadsssdsd.php')">Cipa</button>
            <button onclick="openAlbum('cipadsssdsd.php')">Cipa</button>
            <button onclick="openAlbum('cipadsssdsd.php')">Cipa</button>
            <button onclick="openAlbum('cipadsssdsd.php')">Cipa</button>
            <button onclick="openAlbum('cipadsssdsd.php')">Cipa</button>
            <button onclick="openAlbum('cipadsssdsd.php')">Cipa</button>
            <button onclick="openAlbum('cipadsssdsd.php')">Cipa</button>
            <button onclick="openAlbum('cipadsssdsd.php')">Cipa</button>
        </div>
        <div class="hidden-album">
    <h3>Najít skryté album:</h3>
    <input type="text" id="hiddenAlbumCode" placeholder="Zadejte kód alba" style="padding: 10px; font-size: 16px;">
    <button onclick="findHiddenAlbum()" style="padding: 10px; font-size: 16px; margin-top: 10px;">Otevřít album</button>
</div>
<div id="errorMessage" style="color: red; font-size: 16px; height: 24px; margin-top: 10px;"></div>


    </div>
  

    <div class="gallery">
        <?php
            $dir = "festival";
            $files = array_diff(scandir($dir), array('.', '..'));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $images = [];

            foreach ($files as $file) {
                $file_path = "$dir/$file";
                $extension = pathinfo($file_path, PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), $allowed_extensions)) {
                    $timestamp = filemtime($file_path);
                    $images[] = [
                        'path' => $file_path,
                        'name' => $file,
                        'timestamp' => $timestamp
                    ]; 
                }
            }
            usort($images, function($a, $b) {
                $isPinA = preg_match('/pin(\d*)/i', $a['name'], $matchA) ? (int)($matchA[1] ?? 0) : PHP_INT_MAX;
                $isPinB = preg_match('/pin(\d*)/i', $b['name'], $matchB) ? (int)($matchB[1] ?? 0) : PHP_INT_MAX;
                return $isPinA - $isPinB ?: $b['timestamp'] - $a['timestamp'];
            });

            foreach ($images as $image) {
                $image_info = getimagesize($image['path']);
                $width = $image_info[0];
                $height = $image_info[1];
                $class = ($width > $height) ? 'wide' : '';
                $thumbnail = "{$image['path']}?resize=small";
                echo "<div class='photo-container $class' onclick='openFullscreen(\"{$image['path']}\")'>";
                echo "<img src='$thumbnail' alt='Fotografie'>";
                echo "</div>";
            }
        ?>
    </div>

    <!-- Fullscreen modal -->
    <div id="fullscreenModal" class="fullscreen" style="display: none;">
        <a id="downloadBtn" class="download-btn" download><img src="icons/8542038_download_data_icon.svg" alt="Download"></a>
        <img id="fullscreenImg" src="">
        <img class="close-btn" src="icons/4879885_close_cross_delete_remove_icon.svg" alt="Close" onclick="closeFullscreen()">
    </div>



    <script>

    function openFullscreen(src) {
            document.getElementById("fullscreenImg").src = src;
            document.getElementById("fullscreenModal").style.display = "flex";
            document.getElementById("downloadBtn").href = src;
        }

        function closeFullscreen() {
            document.getElementById("fullscreenModal").style.display = "none";
        }

        function openAlbumPopup() {
    document.getElementById("albumPopup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeAlbumPopup() {
    document.getElementById("albumPopup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
    clearError(); // Skryje chybovou zprávu

}


        function openAlbum(page) {
            window.location.href = page;
        }
        

        function findHiddenAlbum() {
    const code = document.getElementById("hiddenAlbumCode").value.trim();
    const errorMsg = document.getElementById("errorMsg");

    if (code) {
        const albumUrl = code + ".php";

        fetch(albumUrl, { method: 'HEAD' })
            .then(response => {
                if (response.ok) {
                    window.location.href = albumUrl;
                } else {
                    showError("Album neexistuje!");
                }
            })
            .catch(() => {
                showError("Album neexistuje!");
            });
    } else {
        showError("Zadejte kód alba!");
    }
}

function showError(message) {
    const errorElement = document.getElementById("errorMessage");
    errorElement.textContent = message;
}

function clearError() {
    const errorElement = document.getElementById("errorMessage");
    errorElement.textContent = ""; // Vymaže text, ale prostor zůstane
}
document.getElementById("hiddenAlbumCode").addEventListener("keydown", function(event) {
    if (event.key === "Enter") { 
        event.preventDefault(); // Zabrání tomu, aby Enter odeslal formulář
        findHiddenAlbum(); // Spustí funkci pro otevření alba
    }
});
function downloadGallery() {
    window.location.href = 'stahnout_galerii.php';
}





// Schová chybu při psaní
document.getElementById("hiddenAlbumCode").addEventListener("input", clearError);



    </script>
    </body>
</html>