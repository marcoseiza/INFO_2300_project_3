let trashs = document.querySelectorAll('.board__info__options_menu__trash')

trashs.forEach(trash => {
  trash.addEventListener('click', function(e){
    let confirmation = trash.querySelector('.trash-confirmation')
    let svg = trash.querySelector('svg')
    // if (confirmation.querySelector('.trash-checkmark') === e.target) return;

    if (confirmation.style.display == 'none' || confirmation.style.display === "") {
      confirmation.style.display = 'grid'
      confirmation.previousElementSibling.style.opacity = 0
      svg.querySelector('g.lid').style.transform = 'rotate(5deg)'
    } else {
      confirmation.style.display = 'none'
      confirmation.previousElementSibling.style.opacity = 1
      svg.querySelector('g.lid').style.transform = 'rotate(0deg)'
    }
  })
});

window.addEventListener('click', function(e){
  let options = document.querySelectorAll('.board__info__options')
  // console.log(options)
  options.forEach(menu=> {
    let input = menu.nextElementSibling

    if (menu.contains(e.target) || input.nextElementSibling.contains(e.target)){
      input.checked = true
      console.log(input.checked)
    } else{
      input.checked = false
    }
  })
});
