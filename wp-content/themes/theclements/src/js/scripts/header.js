 // Menu elements
 const toggleButton = document.querySelector('.header__menu-toggle');
 const menu = document.querySelector('.menu');

 // Function to close menu
 function closeMenu() {
     menu.classList.remove('menu--active');
     toggleButton.classList.remove('state-x');
     setTimeout(() => toggleButton.classList.remove('state-square'), 300);
 }

 // Handle the main menu toggle
 toggleButton.addEventListener('click', function(e) {
     e.stopPropagation();

     const isMenuActive = menu.classList.contains('menu--active');

     if (isMenuActive) {
         closeMenu();
     } else {
         this.classList.add('state-square');
         setTimeout(() => this.classList.add('state-x'), 300);
         menu.classList.add('menu--active');
     }
 });

 // Prevent clicks inside the menu from closing it
 menu.addEventListener('click', function(e) {
     e.stopPropagation();
 });

 // Close menu when clicking outside
 document.addEventListener('click', function(e) {
     if (menu.classList.contains('menu--active')) {
         closeMenu();
     }
 });

 // Close menu on ESC key
 document.addEventListener('keydown', function(e) {
     if (e.key === 'Escape' && menu.classList.contains('menu--active')) {
         closeMenu();
     }
 });

 // Accordion toggle function
 function toggleMenu(element) {
     const allSections = document.querySelectorAll('.menu__section');
     const parentSection = element.parentElement;
     const linksContainer = parentSection.querySelector('.menu__links');
     const links = parentSection.querySelectorAll('.menu__link');

     // Close all other sections
     allSections.forEach(section => {
         if (section !== parentSection) {
             section.classList.remove('active');
             section.querySelector('.menu__links').style.maxHeight = null;
         }
     });

     // Toggle current section
     if (parentSection.classList.contains('active')) {
         parentSection.classList.remove('active');
         linksContainer.style.maxHeight = null;
     } else {
         parentSection.classList.add('active');
         linksContainer.style.maxHeight = linksContainer.scrollHeight + 'px';

         // Staggered animations for links
         links.forEach((link, index) => {
             link.style.setProperty('--fade-delay', `${index * 0.1}s`);
         });
     }
 }

 // Automatically open the first menu section on load
 window.addEventListener('DOMContentLoaded', () => {
     const firstSection = document.querySelector('.menu__section');
     if (firstSection) {
         firstSection.classList.add('active');
         const linksContainer = firstSection.querySelector('.menu__links');
         linksContainer.style.maxHeight = linksContainer.scrollHeight + 'px';
         const links = firstSection.querySelectorAll('.menu__link');

         // Apply staggered animations for links
         links.forEach((link, index) => {
             link.style.setProperty('--fade-delay', `${index * 0.1}s`);
         });
     }
 });