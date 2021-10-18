<?php
include "head.php";
include "authPHP.php";
//If they are accessing this page without an invite link then send them to dashboard
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
        <!-- Prints the link -->
        <div id="copy-link">
            <textarea href=<?php echo "\"{$_SESSION['inviteLink']}\"" ?>><?php echo $_SESSION['inviteLink'] ?></textarea>
        </div>
        <!-- Displays the QR code -->
        <div id="qrcode"></div>

        <script type="text/javascript" defer>
            //Generates the QR code
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: <?php echo "\"{$_SESSION['inviteLink']}\"" ?>,
                colorDark: "#0297a2",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            //Makes the link copy-able upon click
            document.querySelector("#copy-link textarea").onclick = (e) => {
                console.log(e);
            }
        </script>
    </div>
    <?php
    include "footer.php";
    ?>
</body>