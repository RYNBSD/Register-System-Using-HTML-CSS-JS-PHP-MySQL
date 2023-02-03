'use strict';

const switchBg = document.querySelector(".forms__switch");
const switchBtn = document.querySelector(".forms__switch-btn");

const login = document.querySelector(".forms__container-login");
const signup = document.querySelector(".forms__container-signup");

const name = document.querySelector(".name");
const emails = document.querySelectorAll(".email");
const passwords = document.querySelectorAll(".password");

let isSignup = true;

const modifyElements = () => {
  isSignup = !isSignup;
  switchBg.style.left = isSignup ? "0" : "50%";
  switchBg.style.borderRadius = isSignup ? "20px 0px 0px 20px" : "0px 20px 20px 0px";
  switchBtn.innerHTML = isSignup ? "Login" : "Signup";
  name.value = "";
  emails.forEach(email => email.value = "");
  passwords.forEach(password => password.value = "");
}

switchBtn.addEventListener('click', modifyElements);

//http://localhost/Projects/youtube/routes/login.php

function getEmail() {
  let result = "";

  emails.forEach(email => {
    if (email.value.length) {
      result = email.value;
    }
  });

  return result;
}

function getPassword() {
  let result = "";

  passwords.forEach(password => {
    if (password.value.length) {
      result = password.value;
    }
  });

  return result;
}

login.addEventListener("submit", async function (e) {
  e.preventDefault();

  const response = await fetch(`http://localhost/Projects/youtube/routes/login.php?email=${getEmail()}&password=${getPassword()}`, {
    method: "POST",
  });

  const data = await response.json();

  if (!response.ok) {
    alert(`${data}`);
    return;
  }

  console.log(data);
});

signup.addEventListener('submit', async (e) => {
  e.preventDefault();

  const response = await fetch(`http://localhost/Projects/youtube/routes/signup.php?name=${name.value}&email=${getEmail()}&password=${getPassword()}`, {
    method: "POST",
  });

  const data = await response.json();
  alert(`${data}`);
});