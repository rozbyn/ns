function TestRenderer() {
    this.setCanvas();
    this.setDeviceDimensions();
    this.setListeners();
    this.renderGrid();
    this.setCubeSizes();
    this.renderCube();
    this.setViewPoint();

}


TestRenderer.prototype.setCanvas = function () {
    this.canvas = document.getElementById('canvas');
    if (this.canvas.width !== this.canvas.clientWidth || this.canvas.height !== this.canvas.clientHeight) {
        this.canvas.width = this.canvas.clientWidth;
        this.canvas.height = this.canvas.clientHeight;
    }
    this.ctx = this.canvas.getContext('2d');
    this.gridOffsetX = 0.5;
    this.gridOffsetY = 0.5;
};


TestRenderer.prototype.setDeviceDimensions = function () {
    this.deviceDimensions = {};
    this.deviceDimensions.element = document.getElementById('dimensions-div');
    this.deviceDimensions.devicePixelRatio = window.devicePixelRatio || 1;
    this.deviceDimensions.dpi_x = this.deviceDimensions.element.offsetWidth * this.deviceDimensions.devicePixelRatio;
    this.deviceDimensions.dpi_y = this.deviceDimensions.element.offsetHeight * this.deviceDimensions.devicePixelRatio;
    this.deviceDimensions.pixelsInCmX = Math.ceil(this.deviceDimensions.dpi_x / 2.54);
    this.deviceDimensions.pixelsInCmY = Math.ceil(this.deviceDimensions.dpi_y / 2.54);
};


TestRenderer.prototype.setListeners = function () {
    document.addEventListener('keydown', this.onKeyDown.bind(this))
    document.addEventListener('keyup', this.onKeyUp.bind(this))
};


TestRenderer.prototype.onKeyDown = function (e) {
    if (e.repeat) {
        // return;
    }
    if (e.code === 'KeyW') {
        this.gridOffsetY += e.shiftKey ? 20 : 10;
    }
    if (e.code === 'KeyS') {
        this.gridOffsetY -= e.shiftKey ? 20 : 10;
    }
    if (e.code === 'KeyD') {
        this.gridOffsetX -= e.shiftKey ? 20 : 10;
    }
    if (e.code === 'KeyA') {
        this.gridOffsetX += e.shiftKey ? 20 : 10;
    }
    this.viewPointTargetX = this.viewPointX;
    this.viewPointTargetY = this.viewPointY;
    this.reRenderGrid();
};


TestRenderer.prototype.onKeyUp = function (e) {
    this.reRenderGrid();
};


TestRenderer.prototype.reRenderGrid = function () {
    this.ctx.clearRect(-1000, -1000, this.canvas.width + 1000, this.canvas.height + 1000);
    this.renderGrid();
    this.renderViewPointCircle();
};


TestRenderer.prototype.renderGrid = function (cellSizeX, cellSizeY, offsetX, offsetY) {
    cellSizeX = typeof cellSizeX === 'number' ? cellSizeX : this.deviceDimensions.pixelsInCmX;
    cellSizeY = typeof cellSizeY === 'number' ? cellSizeY : this.deviceDimensions.pixelsInCmY;
    offsetX = typeof offsetX === 'number' ? offsetX : this.gridOffsetX;
    offsetY = typeof offsetY === 'number' ? offsetY : this.gridOffsetY;
    let verticalLinesCount = Math.ceil(this.canvas.width / cellSizeX) + 1;
    let horizontalLinesCount = Math.ceil(this.canvas.height / cellSizeY) + 1;
    [verticalLinesCount, horizontalLinesCount].forEach((linesCount, isHorizontal) => {
        for (let i = 0; i < linesCount; i++) {
            let lineWidth = (verticalLinesCount - 1) * cellSizeY;
            let lineHeight = (horizontalLinesCount - 1) * cellSizeX;
            console.log(verticalLinesCount, horizontalLinesCount, cellSizeX, cellSizeX, lineWidth, lineHeight);
            let moveToX = (isHorizontal ? 0 : cellSizeX) * i + offsetX;
            let moveToY = (isHorizontal ? cellSizeY : 0) * i + offsetY;
            let lineToX = (isHorizontal ? lineWidth + offsetX : moveToX);
            let lineToY = (isHorizontal ? moveToY : lineHeight + offsetY);
            console.log(moveToX, moveToY, lineToX, lineToY);
            this.ctx.beginPath();
            this.ctx.moveTo(moveToX, moveToY);
            this.ctx.lineTo(lineToX, lineToY);
            this.ctx.lineWidth = 1;
            this.ctx.stroke();

        }


    });


};


TestRenderer.prototype.setViewPoint = function () {
    this.viewPointX = this.canvas.width / 2;
    this.viewPointY = this.canvas.height / 2;
    this.viewPointZ = 10 * this.deviceDimensions.pixelsInCmY + 0.5;
    this.renderViewPointCircle();

    this.viewPointTargetX = 0 * this.deviceDimensions.pixelsInCmX + 0.5;
    this.viewPointTargetY = 0 * this.deviceDimensions.pixelsInCmX + 0.5;
    this.viewPointTargetZ = 10;

    this.viewWidth = 90;

};


TestRenderer.prototype.renderViewPointCircle = function () {
    this.ctx.beginPath();
    this.ctx.ellipse(this.viewPointX, this.viewPointY, 5, 5, 0, 0, 2 * Math.PI);
    this.ctx.fillStyle = 'red';
    this.ctx.fill();
};


TestRenderer.prototype.setCubeSizes = function () {
    let cube = this.cube = {};
    cube.x = 25 * this.deviceDimensions.pixelsInCmX;
    cube.y = 10 * this.deviceDimensions.pixelsInCmY;
    cube.z = 0;
    cube.length = 3 * this.deviceDimensions.pixelsInCmX;
    cube.height = 3 * this.deviceDimensions.pixelsInCmX;
    cube.width = 3 * this.deviceDimensions.pixelsInCmY;
};


TestRenderer.prototype.renderCube = function () {
    this.ctx.fillStyle = "green";
    this.ctx.fillRect(this.cube.x, this.cube.y, this.cube.width, this.cube.length);
};






function Countdown(seconds, endCb, tickCb, intervalMsec) {
    if (typeof seconds !== 'number' || seconds <= 0 || seconds !== parseInt(seconds)) {
        throw new Error('Seconds parameter must be positive integer');
    }
    if (typeof intervalMsec !== 'number' || intervalMsec <= 0 || intervalMsec !== parseInt(intervalMsec)) {
        intervalMsec = 10;
    }
    let startTs = (new Date()).getTime();
    let endTs = (new Date()).getTime() + (seconds * 1000);
    let interval = setInterval(() => {
        const currTs = (new Date()).getTime();
        if (typeof tickCb === 'function') {
            tickCb(currTs, startTs, endTs, intervalMsec);
        }
        console.log(currTs - endTs);
        if (currTs >= endTs) {
            clearInterval(interval);
            if (typeof endCb === 'function') {
                endCb(startTs, currTs);
            }
        }
    }, intervalMsec);


}


function CountdownDisplay(seconds, endCb) {

    let div = document.createElement('div');
    div.style.position = 'absolute';
    div.style.top = '15px';
    div.style.left = '15px';
    div.style.backgroundColor = '#ffffff';
    div.style.padding = '10px';
    div.style.fontSize = '40px';
    div.style.fontFamily = 'system-ui';
    let hoursSpan = document.createElement('span');
    let firstDotsSpan = document.createElement('span');
    let minutesSpan = document.createElement('span');
    let secondDotsSpan = document.createElement('span');
    firstDotsSpan.innerHTML = secondDotsSpan.innerHTML = ':';
    firstDotsSpan.style.margin = secondDotsSpan.style.margin = '1px';
    firstDotsSpan.style.position = secondDotsSpan.style.position = 'relative';
    firstDotsSpan.style.top = secondDotsSpan.style.top = '-3px';
    let secondsSpan = document.createElement('span');
    let dotSpan = document.createElement('span');
    dotSpan.innerHTML = '.';
    let millisecondsSpan = document.createElement('span');
    div.appendChild(hoursSpan);
    div.appendChild(firstDotsSpan);
    div.appendChild(minutesSpan);
    div.appendChild(secondDotsSpan);
    div.appendChild(secondsSpan);
    div.appendChild(dotSpan);
    div.appendChild(millisecondsSpan);
    document.body.appendChild(div);
    let countDown = new Countdown(seconds,
        (startTs, currTs) => {

        },
        (currTs, startTs, endTs, intervalMsec) => {
            let diff = endTs - currTs;
            let milliseconds = (diff % 1000).toString();
            let hours = Math.floor(diff / 3600000).toString();
            let minutes = Math.floor((diff % 3600000) / 60000).toString();
            let seconds = Math.floor((diff % 60000) / 1000).toString();
            hours = hours.length < 2 ? '0' + hours : '' + hours;
            minutes = ('0'.repeat(2 - minutes.length)) + minutes;
            seconds = ('0'.repeat(2 - seconds.length)) + seconds;
            milliseconds = ('0'.repeat(3 - milliseconds.length)) + milliseconds;
            if (hoursSpan.innerHTML !== hours) {
                hoursSpan.innerHTML = hours;
            }
            if (minutesSpan.innerHTML !== minutes) {
                minutesSpan.innerHTML = minutes;
            }
            if (secondsSpan.innerHTML !== seconds) {
                secondsSpan.innerHTML = seconds;
                firstDotsSpan.style.visibility = firstDotsSpan.style.visibility === 'hidden' ? '' : 'hidden';
                secondDotsSpan.style.visibility = firstDotsSpan.style.visibility;
            }
            millisecondsSpan.innerHTML = milliseconds;
        }
    );


}


(function () {
    const renderer = new TestRenderer();


})()


