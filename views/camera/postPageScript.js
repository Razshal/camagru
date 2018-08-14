window.onload = async () => {

    const captureButton = document.getElementById('captureButton');
    const video = document.getElementById('video');
    const userFile = document.getElementById("userFile");
    const errorPlace = document.getElementById("errorPlace");
    const cameraPlace = document.getElementById('cameraPlace');
    const canvas = document.getElementById('canvas');
    const filters = {};
    const cameraConstraints =
        {
            audio: false,
            video: {
                width: 1280,
                height: 720,
                facingMode: 'user'
            }
        };

    /************** Camera preview dynamic size **************/

    if (document.body.clientWidth <= 1024) {
        cameraPlace.width = document.body.clientWidth;
        video.width = document.body.clientWidth;
    } else
        video.width = 1024;
    video.height = video.width / 16 * 9;
    cameraPlace.height = cameraPlace.width / 16 * 9;

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
    navigator.mediaDevices.getUserMedia(cameraConstraints)
        .then(function(stream) {
            if ("srcObject" in video)
                video.srcObject = stream;
            else
                video.src = window.URL.createObjectURL(stream);
            video.onloadedmetadata = video.play();
        })
        .catch(function(error) {
            errorPlace.style.display = "block";
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

    /************** Filter **************/


    for (let i = 0; i < 3; i++) {
        filters[i] = new Image();
        filters[i].width = video.width;
        filters[i].height = video.height;
        filters[i].style.display = 'block';
        filters[i].style.position = 'absolute';
        filters[i].style.top = 0;
        filters[i].style.left = 0;
    }
    filters[0].src = "/views/camera/filters/Batman.png";
    cameraPlace.appendChild(filters[0]);

    /************** Load User Picture **************/

    userFile.onchange = () => {
        video.style.display = "none";
        canvas.getContext('2d').drawImage(this.files[0], 0, 0);
    };
};