  var count = 0;
  function rotate() {
    var elem = document.getElementById('div1');
    elem.style.MozTransform = 'scale(0.5) rotate('+count+'deg)';
    elem.style.WebkitTransform = 'scale(0.5) rotate('+count+'deg)';
    if (count==360) { count = 0 }
    count+=45;
    window.setTimeout(rotate, 100);
  }
  window.setTimeout(rotate, 100);
