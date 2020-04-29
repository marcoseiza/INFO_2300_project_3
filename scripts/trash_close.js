let input = document.getElementById('options'),
    options_menu = document.querySelector('.options_menu'),
    trash = document.querySelector('.options_menu__trash')

window.addEventListener('click', function(e){
  if (document.querySelector('.prevw__options').contains(e.target) || options_menu.contains(e.target)){
    input.checked = true
  } else{
    input.checked = false
  }
});

trash.addEventListener('click', function(){
  let confirmation = trash.querySelector('.trash-confirmation')
  let svg = trash.querySelector('svg')
  if (confirmation.style.display == 'none' || confirmation.style.display === "") {
    confirmation.style.display = 'grid'
    document.querySelector('.delete_title').style.opacity = 0
    svg.querySelector('g.lid').style.transform = 'rotate(5deg)'
  } else {
    confirmation.style.display = 'none'
    document.querySelector('.delete_title').style.opacity = 1
    svg.querySelector('g.lid').style.transform = 'rotate(0deg)'
  }
})
