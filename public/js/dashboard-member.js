/**
 * Dashboard Member JavaScript
 * Menangani interaksi sidebar anggota
 */

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.quick-join-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const agendaId = btn.getAttribute('data-agenda-id');
            // Redirect ke halaman join agenda
            window.location.href = '/absensi/agenda/' + agendaId + '/join';
        });
    });
});
