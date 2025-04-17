function openPasscodePopup() {
    document.getElementById("passcodePopup").classList.remove("hidden");
}

function closePasscodePopup() {
    document.getElementById("passcodePopup").classList.add("hidden");
}

function submitFinalForm() {
    const passcode = document.getElementById("passcode").value;
    if (!/^\d{4}$/.test(passcode)) {
        alert("Please enter a valid 4-digit passcode.");
        return;
    }

    const form = document.getElementById("nurseForm");
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "passcode";
    input.value = passcode;
    form.appendChild(input);

    form.submit();
}

