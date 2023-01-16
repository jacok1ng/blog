const backdrop = document.querySelector(".backdrop")
const closeBtn = document.querySelectorAll(".close-btn")
const addCommentElements = document.querySelectorAll(".add-comment")
const registerBtn = document.querySelector("#register")
const loginBtn = document.querySelector("#login")
const commentForm = document.querySelector("#comment-form")
const registerForm = document.querySelector("#register-form")
const loginForm = document.querySelector("#login-form")
//Register
const regNick = document.querySelector("#reg-nick")
const regPassword = document.querySelector("#reg-password")
const regEmail = document.querySelector("#reg-email")
const captchaInput = document.querySelector('input[name="captcha-input"]')
const submitRegister = document.querySelector("#register-btn")
//Login
const loginNick = document.querySelector("#login-nick")
const loginPassword = document.querySelector("#login-password")
const loginEmail = document.querySelector("#login-email")

const MIN_INPUT_LENGTH = 5
const emailRegex = new RegExp(
  /^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+$/
)

submitRegister.addEventListener("click", (e) => {
  const { value: nickVal } = regNick
  const { value: emailVal } = regEmail
  const { value: passVal } = regPassword
  const { value: captchaVal } = captchaInput
  let error = false
  e.preventDefault()

  if (
    !nickVal.trim() ||
    nickVal.trim().includes(" ") ||
    nickVal.trim().length < MIN_INPUT_LENGTH
  ) {
    error = true
    return alert("Nick musi zawierac przynajmniej 5 znaków")
  }

  if (!emailVal.trim() || !emailRegex.test(emailVal.trim())) {
    error = true
    return alert("Twój email nie spełnia wymagań!")
  }

  if (!passVal.trim() || passVal.trim().length < MIN_INPUT_LENGTH) {
    error = true
    return alert("Hasło musi zawierac przynajmniej 5 znaków")
  }

  if (!captchaVal.trim()) {
    error = true
    return alert("Wypełnij pole captcha")
  }

  if (!error) document.querySelector("#register-formula").submit()
})

addCommentElements.forEach((item) =>
  item.addEventListener("click", () => {
    backdrop.style.display = "block"
    commentForm.style.display = "block"
    registerForm.style.display = "none"
    loginForm.style.display = "none"
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
  loginForm.style.display = "none"
})

loginBtn.addEventListener("click", () => {
  backdrop.style.display = "block"
  loginForm.style.display = "block"
  commentForm.style.display = "none"
  registerForm.style.display = "none"
})
