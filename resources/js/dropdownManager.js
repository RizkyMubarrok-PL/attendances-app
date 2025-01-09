class DropdownManager {
    constructor(primaryDropdownId, dependentDropdownId, showCondition) {
        this.primaryDropdown = document.getElementById(primaryDropdownId);
        this.dependentDropdown = document.getElementById(dependentDropdownId);
        this.showCondition = showCondition;

        this.initialize();
    }

    initialize() {
        this.primaryDropdown.addEventListener("change", this.handleSelectionChange.bind(this));
    }

    handleSelectionChange(event) {
        const selectedValue = event.target.value;

        if (this.showCondition == selectedValue) {
            this.showDependentDropdown();
        } else {
            this.hideDependentDropdown();
        }
    }

    showDependentDropdown() {
        this.dependentDropdown.classList.remove("hidden");
    }

    hideDependentDropdown() {
        this.dependentDropdown.classList.add("hidden");
    }
}

export default DropdownManager;