import './bootstrap';
import 'flowbite';
import AnimatedDropdown from './animatedDropdown';
import DropdownManager from './dropdownManager';

// const trigger = document.querySelector('#dropdown-trigger');
// const menu = document.querySelector('#dropdown-menu');
// const dropdown = new AnimatedDropdown(trigger, menu);

const roleAndClass = new DropdownManager('role', 'class-menu', 'Siswa')

function togglePassword(inputTextId) {
    const passwordInput = document.getElementById(inputTextId);
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}
