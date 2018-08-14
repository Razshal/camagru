window.onload = async () => {

    const captureButton = document.getElementById('captureButton');
    const video = document.getElementById('video');
    const userFile = document.getElementById("userFile");
    const errorPlace = document.getElementById("errorPlace");
    const cameraPlace = document.getElementById('cameraPlace');
    const canvas = document.getElementById('canvas');

    /************** Camera Stream **************/

    if (navigator.mediaDevices === undefined)
        navigator.mediaDevices = {};
    if (navigator.mediaDevices.getUserMedia === undefined) {
        navigator.mediaDevices.getUserMedia = constraints => {
            let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
            if (!getUserMedia)
                return Promise.reject(new Error('Cannot use camera with your browser'));
            return new Promise(function(resolve, reject) {
                getUserMedia.call(navigator, constraints, resolve, reject);
            });
        }
    }
    navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 1280, height: 720 } })
        .then(function(stream) {
            if ("srcObject" in video)
                video.srcObject = stream;
            else
                video.src = window.URL.createObjectURL(stream);
            video.onloadedmetadata = video.play();
        })
        .catch(function(error) {
            errorPlace.style.display = "block";
            video.style.display = "none";
            if (error.name === "NotAllowedError")
                errorPlace.innerHTML = "You refused to share your camera";
            else
                errorPlace.innerHTML = error.name + ": " + error.message;
            errorPlace.classList.add("error");
        });

    /************** Camera Caption **************/

    captureButton.onclick = () => {
        canvas.style.display= 'block';
        canvas.width = video.width;
        canvas.height = video.height;
        canvas.getContext('2d').drawImage(video, 0, 0, video.width, video.height);
    };

    /************** Load User Picture **************/

    userFile.onchange = () => {
        canvas.getContext('2d').drawImage(this.files[0], 0, 0);

    };
};