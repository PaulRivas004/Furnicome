const sign_in_btn = document.querySelector("#btnlogin-cliente");
const sign_up_btn = document.querySelector("#btnlogin-empresa");
const container = document.querySelector(".contenedor");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("modo");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("modo");
});