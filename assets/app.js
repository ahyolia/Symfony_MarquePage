import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/style.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

function initTagSelects() {
	const selects = document.querySelectorAll('select[multiple][data-tag-select="true"]');

	selects.forEach((select) => {
		if (select.dataset.tagSelectEnhanced === 'true') {
			return;
		}

		select.dataset.tagSelectEnhanced = 'true';
		select.classList.add('tag-select-native-hidden');

		const container = document.createElement('div');
		container.className = 'tag-select';

		const chips = document.createElement('div');
		chips.className = 'tag-select-chips';

		const searchInput = document.createElement('input');
		searchInput.type = 'text';
		searchInput.className = 'tag-select-search';
		searchInput.placeholder = 'Rechercher un mot-cle...';

		const list = document.createElement('div');
		list.className = 'tag-select-list';

		const optionButtons = [];

		const refresh = () => {
			chips.innerHTML = '';

			Array.from(select.options).forEach((option, index) => {
				if (!optionButtons[index]) {
					return;
				}

				optionButtons[index].classList.toggle('is-selected', option.selected);
			});

			const selected = Array.from(select.selectedOptions);

			if (selected.length === 0) {
				const empty = document.createElement('span');
				empty.className = 'tag-select-empty';
				empty.textContent = 'Aucun mot-cle selectionne';
				chips.appendChild(empty);
				return;
			}

			selected.forEach((option) => {
				const chip = document.createElement('button');
				chip.type = 'button';
				chip.className = 'tag-chip';
				chip.textContent = option.text;

				const remove = document.createElement('span');
				remove.className = 'tag-chip-remove';
				remove.textContent = ' x';
				chip.appendChild(remove);

				chip.addEventListener('click', () => {
					option.selected = false;
					refresh();
				});

				chips.appendChild(chip);
			});
		};

		Array.from(select.options).forEach((option) => {
			const item = document.createElement('button');
			item.type = 'button';
			item.className = 'tag-option';
			item.textContent = option.text;

			item.addEventListener('click', () => {
				option.selected = !option.selected;
				refresh();
				searchInput.focus();
			});

			optionButtons.push(item);
			list.appendChild(item);
		});

		searchInput.addEventListener('input', () => {
			const term = searchInput.value.trim().toLowerCase();

			optionButtons.forEach((button) => {
				const visible = button.textContent.toLowerCase().includes(term);
				button.style.display = visible ? '' : 'none';
			});
		});

		container.appendChild(chips);
		container.appendChild(searchInput);
		container.appendChild(list);
		select.insertAdjacentElement('afterend', container);

		refresh();
	});
}

document.addEventListener('DOMContentLoaded', initTagSelects);
document.addEventListener('turbo:load', initTagSelects);
