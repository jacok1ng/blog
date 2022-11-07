const backdrop = document.querySelector(".backdrop")
const closeBtn = document.querySelector(".close-btn")
const addCommentElements = document.querySelectorAll(".add-comment")

addCommentElements.forEach((item) =>
  item.addEventListener("click", () => (backdrop.style.display = "block"))
)

closeBtn.addEventListener("click", (e) => {
  e.preventDefault()
  backdrop.style.display = "none"
})
