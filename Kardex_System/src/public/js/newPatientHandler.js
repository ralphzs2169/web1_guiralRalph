const newPatientPopup = document.getElementById('newPatientPopup');

function openNewPatientPopup() {
    newPatientPopup.classList.remove('hidden');
}

function closeNewPatientPopup() {
    newPatientPopup.classList.add('hidden');
}

document.getElementById('patientForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert("Patient saved!");
    closeNewPatientPopup();
});