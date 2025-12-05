import './bootstrap';
// Import Chart.js
import Chart from 'chart.js/auto';

// Import ApexCharts
import ApexCharts from 'apexcharts';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Global chat notifications (new messages) via private user channel
document.addEventListener('DOMContentLoaded', () => {
  if (!window.Echo || typeof window.CURRENT_USER_ID === 'undefined') return;

  try {
    // Must match routes/channels.php: Broadcast::channel('user.{id}', ...)
    const channel = window.Echo.private('user.' + window.CURRENT_USER_ID);
    channel.listen('.message.notification', (e) => {
      // Skip toast if we're already on the same chat page
      try {
        const m = window.location.pathname.match(/\/events\/(\d+)\/chat/);
        if (m && Number(m[1]) === Number(e.event_id)) return;
      } catch (_) {}
      // Create a toast with link to the event chat
      const container = document.getElementById('toast-container') || document.body;
      const toast = document.createElement('a');
      toast.href = e.url || '#';
      toast.className = 'block mb-2 z-60 max-w-sm bg-indigo-600 text-white px-4 py-3 rounded shadow hover:bg-indigo-700 transition';
      toast.innerHTML = `<div class="text-sm"><span class="font-semibold">${e.author_name || 'Participant'}</span> a écrit dans <span class="underline">${e.event_title || 'un événement'}</span></div><div class="text-xs opacity-90 mt-1">${(e.snippet || '').toString().slice(0, 120)}</div>`;
      container.appendChild(toast);
      setTimeout(() => { toast.remove(); }, 6000);
    });

    // Vote notifications
    channel.listen('.vote.notification', (e) => {
      const container = document.getElementById('toast-container') || document.body;
      const toast = document.createElement('a');
      toast.href = e.url || '#';
      toast.className = 'block mb-2 z-60 max-w-sm bg-emerald-600 text-white px-4 py-3 rounded shadow hover:bg-emerald-700 transition';
      toast.innerHTML = `<div class="text-sm"><span class="font-semibold">Nouveau vote</span> pour <span class="underline">${(e.participant_name || '').toString()}</span> dans <span class="underline">${(e.event_title || 'événement')}</span></div><div class="text-xs opacity-90 mt-1">Total: ${(e.total_votes || 0)} votes</div>`;
      container.appendChild(toast);
      setTimeout(() => { toast.remove(); }, 6000);
    });
  } catch (_) {
    // ignore
  }
});
