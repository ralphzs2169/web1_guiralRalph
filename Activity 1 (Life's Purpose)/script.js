const profileButton = document.querySelector(".profile-container");
const content = document.querySelector(".content");
const title = document.querySelector(".title");

profileButton.addEventListener("click", () => {
	content.style.display = "flex";
	content.classList.add("show");
	profileButton.style.display = "none";
	title.style.bottom = "30px";
});

content.addEventListener("click", () => {
	profileButton.style.display = "flex";
	content.classList.remove("show");
	content.style.display = "none";
	title.style.bottom = "70px";
});