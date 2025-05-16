document.addEventListener('DOMContentLoaded', function () {
      const freqSelect = document.getElementById('frequency-select');
      const dateRangeContainer = document.getElementById('date-range-container');
      const yearContainer = document.getElementById('year-container');
      function hideAll() {
        dateRangeContainer.classList.add('hidden');
        yearContainer.classList.add('hidden');
      }
      hideAll();
      freqSelect.addEventListener('change', function () {
        const val = this.value;
        if (val === 'monthly' || val === 'quarterly') {
          dateRangeContainer.classList.remove('hidden');
          yearContainer.classList.add('hidden');
        } else if (val === 'annually') {
          yearContainer.classList.remove('hidden');
          dateRangeContainer.classList.add('hidden');
        } else {
          hideAll();
        }
      });
    });