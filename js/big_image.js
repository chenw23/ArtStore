window.onload = function () {
  console.log('search_big_image run');
  var images = document.querySelectorAll(".artThumb");
  console.log(images);
  for (var i = 0; i < images.length; i++) {
    images[i].onmouseover = function () {
      var newNode = document.createElement("span");
      newNode.innerHTML = this.alt;
      newNode.style.border = "solid 1px black";
      newNode.style.zIndex = "4";
      newNode.className = 'bigImg';
      this.parentNode.appendChild(newNode);
    };
    images[i].onmouseout = function () {
      var images = document.querySelectorAll(".bigImg");
      for (var i = 0; i < images.length; i++) {
        images[i].parentNode.removeChild(images[i]);
      }
    }
  }
};
