const backdrop = document.querySelector(".backdrop")
const closeBtn = document.querySelectorAll(".close-btn")
const addCommentElements = document.querySelectorAll(".add-comment")
const registerBtn = document.querySelector("#register")
const commentForm = document.querySelector("#comment-form")
const registerForm = document.querySelector("#register-form")

addCommentElements.forEach((item) =>
  item.addEventListener("click", () => {
    backdrop.style.display = "block"
    commentForm.style.display = "block"
    registerForm.style.display = "none"
    console.log("elo", commentForm.style.display)
  })
)

closeBtn.forEach((item) => {
  item.addEventListener("click", (e) => {
    e.preventDefault()
    backdrop.style.display = "none"
  })
})

registerBtn.addEventListener("click", () => {
  backdrop.style.display = "block"
  registerForm.style.display = "block"
  commentForm.style.display = "none"
})
