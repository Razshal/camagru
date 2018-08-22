<?php ob_start(); ?>
<div id="sideToSide">
    <div class="container">
        <script src="views/camera/postPagePreviewAndSend.js"></script>
        <link rel="stylesheet" type="text/css" href="/views/style/postPage.css">

        <div id="cameraPlace">
            <video autoplay id="video"></video>
            <canvas id="canvas"></canvas>
        </div>
        <div id="buttons">
            <button id="captureButton" disabled>Snap</button>
            <button id="clearButton">Clear</button>
        </div>
        <div id="filtersBar">
        </div>
        Or send from your computer<br/>
        <input type="file" accept="image/*" name="userFile" id="userFile"/>
        <textarea id="desc" placeholder="Post description" name="text"></textarea>
        <button id="sendButton">Send</button>
    </div>
    <div id="previousPosts">

    </div>
</div>
<?php $content = ob_get_clean(); ?>
