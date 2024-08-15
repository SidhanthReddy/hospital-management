function showContent(id) {
    const contents = document.querySelectorAll('.content');
    contents.forEach(content => {
        content.classList.remove('active');
    });

    const selectedContent = document.getElementById(id);
    if (selectedContent) {
        selectedContent.classList.add('active');
    }

    if (id === 'logout') {
        showLogoutModal();
    }
}

function showLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.style.display = 'block';
}

document.getElementById('logout-link').addEventListener('click', function(event) {
    event.preventDefault();
    showContent('logout');
});

document.getElementById('confirmLogout').addEventListener('click', function() {
    window.location.href = 'dlogin.php';
});

document.getElementById('cancelLogout').addEventListener('click', function() {
    window.location.href = 'dashboard.php';
});

window.addEventListener('click', function(event) {
    const modal = document.getElementById('logoutModal');
    if (event.target === modal) {
        modal.style.display = 'none';
        document.getElementById('medicines').classList.add('active');  // Revert to default section
    }
});
