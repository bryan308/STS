        // Get the theme radio buttons
        const radioButtons = document.querySelectorAll('.theme-radio .radio');

// Function to handle theme change
function handleThemeChange() {
    const selectedTheme = this.value;

    // Remove existing theme classes
    document.body.classList.remove('default', 'blue', 'dark');

    // Add class based on selected theme
    if (selectedTheme === 'default') {
        document.body.classList.add('default');
    } else if (selectedTheme === 'blue') {
        document.body.classList.add('blue');
    } else if (selectedTheme === 'dark') {
        document.body.classList.add('dark');
    }
}

// Add event listener to each radio button
radioButtons.forEach((radio) => {
    radio.addEventListener('change', handleThemeChange);
});