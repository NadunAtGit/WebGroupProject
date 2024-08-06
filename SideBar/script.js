// Function to toggle sidebar
let btn = document.querySelector("#btn");
let sidebar = document.querySelector(".sidebar");

btn.onclick = function() {
    sidebar.classList.toggle("active");
};

// Function to show content based on the clicked item
function showContent(section) {
    const mainContent = document.getElementById('main-content');
    
    // Clear the main content area
    mainContent.innerHTML = '';

    // Show content based on the section
    if (section === 'dashboard') {
        fetch('../Dashboard/Dashboard.php')
            .then(response => response.text())
            .then(data => {
                mainContent.innerHTML = data;
            })
            .catch(error => {
                mainContent.innerHTML = '<p>Error loading content 1.</p>';
                console.error('Error fetching Users.php:', error);
            });
    } else if (section === 'products') {
        mainContent.innerHTML = '<h1>Products</h1><p>Here are your products.</p>';
    }  else if (section === 'suppliers') {
        fetch('../Suppliers/Suppliers.php')
            .then(response => response.text())
            .then(data => {
                mainContent.innerHTML = data;
            })
            .catch(error => {
                mainContent.innerHTML = '<p>Error loading content 1.</p>';
                console.error('Error fetching Users.php:', error);
            });
    }
     else if (section === 'settings') {
        mainContent.innerHTML = '<h1>Settings</h1><p>Change your settings here.</p>';
    } else if (section === 'customers') {
        // Fetch content from Users.php and display it
        fetch('../Users/Users.php')
            .then(response => response.text())
            .then(data => {
                mainContent.innerHTML = data;
            })
            .catch(error => {
                mainContent.innerHTML = '<p>Error loading content 2.</p>';
                console.error('Error fetching Users.php:', error);
            });
    }else if (section === 'delete-users'){
        fetch('../Users/Users.php')
            .then(response => response.text())
            .then(data => {
                mainContent.innerHTML = data;
            })
            .catch(error => {
                mainContent.innerHTML = '<p>Error loading content 2.</p>';
                console.error('Error fetching Users.php:', error);
            });

    }
}
