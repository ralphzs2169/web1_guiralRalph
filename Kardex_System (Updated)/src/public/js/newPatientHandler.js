const newPatientPopup = document.getElementById('newPatientPopup');
const addNewPatientBtn = document.getElementById('new-patient');
const closePatientForm = document.getElementById('close-patientForm');

const firstname = document.getElementById('first-name');
const midInit = document.getElementById('middle-initial');
const lastname = document.getElementById('last-name');
const bed = document.getElementById('bed');
const dateOfBirth = document.getElementById('dob');
const gender = document.getElementById('gender');
const civilStatus = document.getElementById('status');
const nationality = document.getElementById('nationality');
const religion = document.getElementById('religion');
const physician = document.getElementById('physician');
const diagnosis = document.getElementById('diagnosis');

document.getElementById('patientForm').addEventListener('submit', function(e) {
    e.preventDefault();
    submitNewPatientData();
    closeNewPatientPopup();
});

function getPatientData() {
    return {
        lastname: lastname.value.trim(),
        firstname: firstname.value.trim(),
        midInit: midInit.value.trim(),
        bedId: bed.value.trim(),
        dob: dateOfBirth.value,
        gender: gender.value,
        civilStatus: civilStatus.value.trim(),
        nationality: nationality.value.trim(),
        religion: religion.value.trim(),
        physician: physician.value.trim(),
        diagnosis: diagnosis.value.trim()
    };
}

async function submitNewPatientData(){
    const patientData = getPatientData();

    try {
        const response = await fetch("/kardex_system/src/routes/index.php/addPatient", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(patientData)
        });
        console.log(patientData.dob);
        const result = await response.text();
        console.log(result);

        if (!result.success) {

          
          return false;
        }
  
        alert("New Patient Added");
  
        return true;
      } catch (err) {
          console.log(err);
        alert("Something went wrong. Please try again");
        return false;
      }
}


function openNewPatientPopup() {
    newPatientPopup.classList.remove('hidden');
}

function closeNewPatientPopup() {
    newPatientPopup.classList.add('hidden');
}

addNewPatientBtn.addEventListener('click', () => openNewPatientPopup());
closePatientForm.addEventListener('click', () => closeNewPatientPopup());

