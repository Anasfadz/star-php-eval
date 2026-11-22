import Swal from 'sweetalert2';

window.Swal = Swal;

document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-confirm-delete')) {
        return;
    }

    event.preventDefault();
    const title = form.getAttribute('data-confirm-delete') || 'this article';

    Swal.fire({
        title: 'Delete article?',
        text: `Are you sure you want to delete "${title}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#71717a',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            form.removeAttribute('data-confirm-delete');
            form.submit();
        }
    });
});
