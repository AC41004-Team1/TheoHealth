<?php
include "head.php";
include "authPHP.php";
if (!isset($_SESSION['inviteLink'])) {
    header('Location: dashboard.php');
}
?>
<title>Invite</title>

<link rel="stylesheet" href="./resources/styles/invite.css">
<link rel="stylesheet" href="./resources/styles/layout.css">
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

</head>

<body>

    <?php
    include "header.php";
    ?>
    <div id="invite-content">


        <div id="heading-label">
            Provide the Client with the link or QR code below.
        </div>
        <div id="copy-link">

            <textarea href=<?php echo "\"{$_SESSION['inviteLink']}\"" ?>><?php echo $_SESSION['inviteLink'] ?></textarea>
        </div>
        <div id="qrcode"></div>
        <script type="text/javascript" defer>
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: <?php echo "\"{$_SESSION['inviteLink']}\"" ?>,
                colorDark: "#0297a2",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            document.querySelector("#copy-link textarea").onclick = (e) => {
                console.log(e);
            }
        </script>
    </div>
    <?php
    include "footer.php";
    ?>

</body>