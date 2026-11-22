// Check-in page: progress bar, and crisis contacts as soon as PHQ-9 question 9 is answered above zero.
(function () {
  const form = document.getElementById('checkin');
  if (!form) return;
  const groups = [...form.querySelectorAll('fieldset.q')];
  const bar = document.querySelector('.progress .bar i');
  const label = document.getElementById('progress-label');
  const crisis = document.getElementById('crisis-inline');

  function update() {
    const done = groups.filter(g => g.querySelector('input:checked')).length;
    bar.style.width = (done / groups.length * 100) + '%';
    label.textContent = done + ' of ' + groups.length + ' answered';
    const q9 = form.querySelector('input[name="phq9[8]"]:checked');
    if (crisis) crisis.hidden = !(q9 && q9.value !== '0');
  }

  form.addEventListener('change', e => {
    update();
    // Move to the next unanswered question to keep the flow going.
    const g = e.target.closest('fieldset.q');
    const next = groups.slice(groups.indexOf(g) + 1).find(x => !x.querySelector('input:checked'));
    if (next && !(e.target.name === 'phq9[8]' && e.target.value !== '0')) {
      next.scrollIntoView({ behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth', block: 'center' });
    }
  });
  update();
})();
