const sidebar = document.getElementById('sidebar');
const closeBtn = document.getElementById('closeBtn');
const backdrop = document.getElementById('backdrop');
const sections = document.querySelectorAll("main section");

function showSection(sectionId) {
    sections.forEach(section => section.classList.add("hidden"));
    document.getElementById(sectionId).classList.remove("hidden");
    switch(sectionId){
        case 'nurses': viewAllNurses(); break;
        case 'beds': viewAllBeds(); break;
    }
    closeSidebar(); // optional: auto-close sidebar on section switch
}

function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    backdrop.classList.remove('hidden');
}

function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    backdrop.classList.add('hidden');
}



document.querySelectorAll('.hamburger-btn').forEach(btn => {
    btn.addEventListener('click', openSidebar);
});

closeBtn.addEventListener('click', closeSidebar);
backdrop.addEventListener('click', closeSidebar);

showSection('nurses'); // Default section