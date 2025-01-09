class AnimatedDropdown {
    constructor(triggerElement, menuElement) {
        this.trigger = triggerElement;
        this.menu = menuElement;
        this.isOpen = false;
        
        this.init();
    }
    
    init() {
        // Set initial state
        this.menu.style.opacity = '0';
        this.menu.style.transform = 'scale(0.95)';
        this.menu.style.display = 'none';
        
        // Add click event listener to trigger
        this.trigger.addEventListener('click', () => this.toggleMenu());
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.trigger.contains(e.target) && !this.menu.contains(e.target)) {
                this.hideMenu();
            }
        });
    }
    
    toggleMenu() {
        this.isOpen ? this.hideMenu() : this.showMenu();
    }
    
    showMenu() {
        this.menu.style.display = 'block';
        this.menu.style.transition = 'transform ease-out 100ms, opacity ease-out 100ms';
        
        // Force a reflow to ensure the transition works
        this.menu.offsetHeight;
        
        this.menu.style.opacity = '1';
        this.menu.style.transform = 'scale(1)';
        this.isOpen = true;
    }
    
    hideMenu() {
        this.menu.style.transition = 'transform ease-in 75ms, opacity ease-in 75ms';
        this.menu.style.opacity = '0';
        this.menu.style.transform = 'scale(0.95)';
        this.isOpen = false;
        
        // Wait for animation to finish before hiding
        setTimeout(() => {
            if (!this.isOpen) {
                this.menu.style.display = 'none';
            }
        }, 75);
    }
}

export default AnimatedDropdown;