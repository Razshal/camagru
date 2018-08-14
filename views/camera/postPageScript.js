window.onload = async () => {

    const captureButton = document.getElementById('captureButton');
    const video = document.getElementById('video');
    const userFile = document.getElementById("userFile");
    const errorPlace = document.getElementById("errorPlace");
    const cameraPlace = document.getElementById('cameraPlace');
    const canvas = document.getElementById('canvas');
    const filtersBar = document.getElementById('filtersBar');
    const filters = [];
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
                errorPlace.innerHTML = "Camera access not allowed";
            else
                errorPlace.innerHTML = error.name + ": " + error.message;
            errorPlace.classList.add("error");
        });

    /************** Camera Caption **************/

    // if (!document.getElementsByClassName('filter')[0])


    captureButton.onclick = () => {
        canvas.style.display = 'block';
        canvas.width = video.width;
        canvas.height = video.height;
        canvas.getContext('2d').drawImage(video, 0, 0, video.width, video.height);
        document.getElementById('preview')
            .appendChild(document.getElementsByClassName('filter')[0]);
    };

    /************** Filters **************/

    filters[0] = "/views/camera/filters/Batman.png";
    filters[1] = "/views/camera/filters/Anon.png";
    filters[2] = "/views/camera/filters/Carnival.png";

    filters.forEach((elem) => {
        let filterPreview = new Image();
        filterPreview.src = elem;
        filterPreview.classList.add('filterPreview');
        filterPreview.onclick = (event) => {
            let filter = new Image();
            let actualFilters = document.getElementsByClassName('filter');
            filter.src = event.target.src;
            filter.classList.add('filter');
            filter.width = video.width;
            filter.height = video.height;
            while (actualFilters[0])
                actualFilters[0].parentNode.removeChild(actualFilters[0]);
            cameraPlace.appendChild(filter);
        };
        filtersBar.appendChild(filterPreview);
    });

    /************** Load User Picture **************/

    userFile.onchange = () => {
        let userImage = new Image();
        userImage.src = this.files[0];
        video.style.display = "none";
        cameraPlace.appendChild(userImage);
    };
};