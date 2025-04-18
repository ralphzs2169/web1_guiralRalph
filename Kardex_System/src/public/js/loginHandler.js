const login = document.getElementById('login-form');

const department = document.getElementById('department');
const email = document.getElementById('email');
const password = document.getElementById('password');

login.addEventListener('submit', (e) => {
    e.preventDefault();
    loginUser();
})

function getLoginData(){
    return {
        department: department.value.trim(),
        email: email.value.trim(),
        password: password.value.trim()
    }
}

async function loginUser() {
    const loginData = getLoginData();

    try {
      const response = await fetch("/kardex_system/src/routes/index.php/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(loginData)
      });

      const result = await response.json();

      if (!result.success) {
        if (result.errors.emptyDepartment) showInputError(department, result.errors.emptyDepartment);
        if (result.errors.emptyEmail) showInputError(email, result.errors.emptyEmail);
        if (result.errors.emptyPassword) showInputError(password, result.errors.emptyPassword);

        if (result.errors.userNotFound) showInputError(email, result.errors.userNotFound);
        if (result.errors.incorrectPassword) showInputError(password, result.errors.incorrectPassword);
        
        return false;
      }

      redirectUser('../views/userProfile.php');

      return true;
    } catch (err) {
        console.log(err);
      alert("Something went wrong. Please try again");
      return false;
    }
  }

  //simulate a POST request through a hidden form
  function redirectUser(url) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    document.body.appendChild(form);
    form.submit();
  }
  


