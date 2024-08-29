// JavaScript to add interactivity to the test page

document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('testButton');
    const text = document.getElementById('testText');
    
    button.addEventListener('click', () => {
        text.textContent = 'Button was clicked!';
        text.style.color = 'red';
    });
});
