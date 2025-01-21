function adjustSlideshowHeights() {
    // Select all slideshow container elements
    const slideshowContainers = document.querySelectorAll('.slideshow-container, .livingstone-slideshow, .video-container');

    slideshowContainers.forEach(slideshow => {
        // Find the next sibling with the class 'footer-bar'
        const footerBar = slideshow.nextElementSibling;
        if (footerBar && (footerBar.classList.contains('footer-bar') || footerBar.classList.contains('livingstone-footer'))) {
            // Get the height of the footer-bar
            const footerHeight = parseInt(footerBar.offsetHeight);
            
            // Set the max height using string concatenation
            // slideshow.style.maxHeight = 'calc(100dvh - ' + footerHeight + 'px - var(--header-height))';
            // Set the height using string concatenation
            slideshow.style.height = 'calc(100dvh - ' + footerHeight + 'px - var(--header-height))';
        }
    });
}

// Run the function on initial load
adjustSlideshowHeights();

// Run the function again when the window is resized
window.addEventListener('resize', adjustSlideshowHeights);