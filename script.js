// document.getElementById('password').addEventListener()

function checkPass() {
    if (document.getElementById('password').value != document.getElementById('password2').value) {
        document.getElementById('password').style.backgroundColor = 'red';
        document.getElementById('password2').style.backgroundColor = 'red';
        document.getElementById('password2_lbl').innerHTML = 'Retype password: Passwords does not match';
    } else {
        document.getElementById('password').style.backgroundColor = 'white';
        document.getElementById('password2').style.backgroundColor = 'white';
        document.getElementById('password2_lbl').innerHTML = 'Retype password:';
    }
  }
