let input = document.getElementById('update_form_pin_tags'),
    hidden_input = document.getElementById('hidden_update_form_pin_tags'),
    list = document.getElementById('update_form_pin_tag_list'),
    tag = "",
    tag_writing = false,
    tag_numb = hidden_input.value.split('#').length - 1,
    first_warning = false


function escapeHtml(dirty) {
  return dirty.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;")
}

function getColor() {
  let color = 'hsl(' + Math.floor(360 * Math.random()) + ',100%,' + Math.floor(65 + 15 * Math.random()) + '%)'
  return color
}

function addTag(tag) {
  // console.log(hidden_input.value)
  // if tag empty return
  tag = tag.substr(1, tag.length)
  // console.log(tag)
  if (tag === "" || tag == " " || tag == "#") {
    return ""
  }

  // add tag
  const color = getColor()
  input.insertAdjacentHTML("beforebegin", "<span id='form_tag_numb_" + tag_numb + "' style='background-color:" + color + ";'>" + escapeHtml(tag) + " </span>")
  tag_numb += 1
  hidden_input.value += '#' + escapeHtml(tag) + ' ' + color

  // reset
  input.placeholder = ""
  input.value = ""
  tag_writing = false
  return ""
}

function deletePreviousTag () {
  if (first_warning) {
    document.getElementById('form_tag_numb_' + (tag_numb - 1)).remove()
    hidden_input.value = hidden_input.value.substring(0, hidden_input.value.lastIndexOf("#"))
    // console.log(hidden_input.value)
    tag_numb -= 1
    first_warning = false
    if (tag_numb == 0) {
      input.placeholder = "add or delete pins"
    }
  } else {
    latest_tag = document.getElementById('form_tag_numb_' + (tag_numb - 1))
    latest_tag.style.border = '1px solid red'
    first_warning = true
  }
}

input.onkeydown = function () {
  var key = event.keyCode || event.charCode
  value = input.value

  if (key != 8 & key != 46 & tag_numb != 0) {
    latest_tag = document.getElementById('form_tag_numb_' + (tag_numb - 1))
    latest_tag.style.border = 'none'
    first_warning = false
  }
  if ((key == 8 || key == 46) & value.length == 0 & tag_numb != 0) {
    deletePreviousTag()
  }
  if ((key == 8 || key == 46) & value.length != 0) {
    tag = tag.substring(0, tag.length - 2)
  }
  if (key == 13 || key == 32) {
    tag = addTag(tag)
  }

}

input.oninput = function () {
  last = input.value.slice(-1)

  if (last == "#") {
    input.value = "#"
    tag = ""
    tag_writing = true
  }

  if (tag_writing) {
    tag += last
  }
}

// background.innerHTML = "<span>" + safe_value + "</span>"
