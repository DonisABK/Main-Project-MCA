const profile = document.getElementById('user_profile');
const form = document.getElementById('update_form');

const btn = document.getElementById('btn');

btn.addEventListener('click', function handleClick() {
  if (profile.style.visibility === 'hidden') {
    profile.style.visibility = 'visible';
    form.style.visiblity = 'hidden';
  } else {
    profile.style.visibility = 'hidden';
    form.style.visiblity = 'visible';
  }
});