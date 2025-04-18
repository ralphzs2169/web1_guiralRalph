let passcode = "";
let newPasscode = "";
const correctPasscode = "1234"; // Hardcoded passcode for demo

function showPasscodeUI(title, onConfirm) {
  const container = document.getElementById("passcodeContainer");
  container.innerHTML = `
      <h2 class="text-white text-4xl font-bold text-center">${title}</h2>
      <div class="flex justify-center space-x-4" id="dots">
       ${[1, 2, 3, 4].map(i => `<div class="w-5 h-5 rounded-full border border-white" id="dot${i}"></div>`).join('')}
      </div>
      <div class="flex justify-center">
        <div class="grid grid-cols-3 gap-6">
          ${[1,2,3,4,5,6,7,8,9].map(num => `
            <button class="w-16 h-16 bg-white text-[#97b5c4] font-semibold rounded-full sm:text-4xl" onclick="pressKey('${num}')">${num}</button>`).join('')}
          <button class="w-16 h-16 bg-[#ff1a04] hover:bg-[#5eacde] text-white font-semibold rounded-full sm:text-4xl" onclick="clearPasscode()">C</button>
          <button class="w-16 h-16 bg-white text-[#97b5c4] font-semibold rounded-full sm:text-4xl" onclick="pressKey('0')">0</button>
          <button class="w-16 h-16 bg-[#ffb91d] hover:bg-[#5eacde] text-white font-semibold rounded-full sm:text-6xl" onclick="removeLast()">←</button>
        </div>
      </div>
      <div class="flex justify-center mt-4">
        <button class="bg-[#5eacde] hover:bg-[#2320d8] text-white font-bold py-4 px-10 sm:text-3xl rounded-xl hover:shadow-xl transform hover:scale-105 transition duration-300 "
          onclick="${onConfirm}()">Confirm</button>
      </div>
    `;
  container.classList.remove("hidden");
}


function pressKey(num) {
  if (passcode.length < 4) {
    passcode += num;
    updateDots();
  }
}

function updateDots() {
  for (let i = 1; i <= 4; i++) {
    const dot = document.getElementById("dot" + i);
    if (i <= passcode.length) {
      dot.classList.add("bg-white");
    } else {
      dot.classList.remove("bg-white");
    }
  }
}

function clearPasscode() {
  passcode = "";
  updateDots();
}

function removeLast() {
  passcode = passcode.slice(0, -1);
  updateDots();
}

function confirmPasscode() {
  if (passcode === correctPasscode) {
    showPasscodeUI("Set New Task Passcode", "confirmNewPasscode");
    clearPasscode();
  } else {
    document.getElementById("errorModal").classList.remove("hidden");
    clearPasscode();
  }
}

function confirmNewPasscode() {
  if (passcode.length === 4) {
    newPasscode = passcode;
    clearPasscode();
    showPasscodeUI("Enter Password Again", "confirmRetypePasscode");
  } else {
    document.getElementById("errorModal").classList.remove("hidden");
    clearPasscode();
  }
}

function confirmRetypePasscode() {
  if (passcode === newPasscode) {
    showSuccessModal();
  } else {
    document.getElementById("errorModal").classList.remove("hidden");
  }
}

function showSuccessModal() {
  document.getElementById("successModal").classList.remove("hidden");
  clearPasscode();
}

function closeErrorModal() {
  document.getElementById("errorModal").classList.add("hidden");
  clearPasscode();
}

function redirectToLogin() {
  window.location.href = "OncedLog-in.html";
}


showPasscodeUI("Enter Old Task Passcode", "confirmPasscode");