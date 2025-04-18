async function loadPatientFolders() {
    try {
        const response = await fetch("/kardex_system/src/routes/index.php/loadPatientFolders", {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        });

      const result = await response.json();
      console.log(result);
 
      if (!result.success || !Array.isArray(result.data)) {
          console.error("Failed to fetch  patients or data malformed:", result);
          alert("Failed to load bed data.");
          return false;
      }
      
      const patients = result.data;
      const container = document.getElementById('bedContainer');
      container.innerHTML = ''; // Clear existing content if any
  
      patients.forEach(patient => {
        const bedDiv = document.createElement('div');
        bedDiv.className = "flex flex-col items-center transition-transform duration-200 hover:scale-105 cursor-pointer";
        bedDiv.innerHTML = `
          <img src="../public/images/folder-icon.png" alt="Folder" class="w-28 h-24" />
          <p class="font-bold mt-2 text-center">
            BED ${patient.bed_number} - ${patient.patient_name.toUpperCase()}
          </p>
        `;
        container.appendChild(bedDiv);
      });
    } catch (err) {
        console.error("Error fetching beds:", err);
        alert("Something went wrong. Please try again.");
        return false;
    }
  }
  
  // Call the function when needed
  loadPatientFolders();
  