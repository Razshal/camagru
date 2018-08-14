<?php ob_start(); ?>
<script src="views/camera/postPageScript.js"></script>
<link rel="stylesheet" type="text/css" href="/views/style/postPage.css">
<div id="cameraPlace">
    <video autoplay id="video"></video>
</div>
<canvas id="canvas"></canvas>
<button id="captureButton">Snap</button>
Or send from your computer<br/>
<input type="file" accept="image/*" name="userFile" id="userFile"/>
<input type="text" name="title" placeholder="Post title"/>
<textarea placeholder="Post description" name="text"></textarea>

<?php $content = ob_get_clean(); ?>
