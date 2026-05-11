document.addEventListener('DOMContentLoaded', function () {
    // Get drawer element
    const drawerElement = document.getElementById('drawer-navigation');
    const toggleButton = document.querySelector('[data-drawer-toggle="drawer-navigation"]');
    const closeButton = document.querySelector('[data-drawer-hide="drawer-navigation"]');

    if (drawerElement) {
        // Simple toggle without Flowbite
        if (toggleButton) {
            toggleButton.addEventListener('click', function () {
                drawerElement.classList.toggle('-translate-x-full');
            });
        }

        if (closeButton) {
            closeButton.addEventListener('click', function () {
                drawerElement.classList.add('-translate-x-full');
            });
        }
    }
});
