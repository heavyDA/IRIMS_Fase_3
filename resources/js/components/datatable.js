// Core DataTables and Bootstrap 5
import DataTables from 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

// Responsive extension
import 'datatables.net-responsive';
import 'datatables.net-responsive-bs5';
import 'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css';

import 'datatables.net-fixedcolumns';
import 'datatables.net-fixedcolumns-bs5';
import 'datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css';

import debounce from '~js/utils/debounce';

DataTables.Api.registerPlural(
	'columns().searchable()',
	'column().searchable()',
	function (selector, opts) {
		return this.iterator(
			'column',
			function (settings, column) {
				return settings.aoColumns[column].bSearchable;
			},
			1
		);
	}
);

DataTables.Api.registerPlural(
	'columns().fieldType()',
	'column().fieldType()',
	function (selector, opts) {
		return this.iterator(
			'column',
			function (settings, column) {
				return settings.aoColumns[column].fieldType ?? 'text';
			},
			1
		);
	}
);

DataTables.Api.registerPlural(
	'columns().fieldTypeData()',
	'column().fieldTypeData()',
	function (selector, opts) {
		return this.iterator(
			'column',
			function (settings, column) {
				return settings.aoColumns[column].fieldTypeData ?? [];
			},
			1
		);
	}
);

DataTables.Api.registerPlural(
	'columns().searchOperator()',
	'column().searchOperator()',
	function (selector, opts) {
		return this.iterator(
			'column',
			function (settings, column) {
				return settings.aoColumns[column].operator ?? '';
			},
			1
		);
	}
);

const createDatatable = (target = 'table', options) => {
	const createColumnSearchField = (column, type, operator, data = []) => {
		let element;
		if (type === 'select') {
			element = document.createElement('select');
			element.classList.add('form-select');

			// Prevent sorting when clicking select
			element.addEventListener('click', (e) => {
				e.stopPropagation();
			});

			for (let item of data) {
				let option = document.createElement('option');
				option.value = item;
				option.innerHTML = item;

				element.append(option);
			}
		} else {
			element = document.createElement('input');
			element.type = type;
			element.classList.add('form-control', 'form-control-sm');

			// Prevent sorting when clicking input
			element.addEventListener('click', (e) => {
				e.stopPropagation();
			});

			element.addEventListener(
				'keydown',
				debounce(() => {
					if (column.search() !== element.value) {
						column
							.search(
								operator
									? operator + '___' + element.value
									: element.value
							)
							.draw();
					}
				})
			);

			if (type !== 'text') {
				element.addEventListener(
					'change',
					debounce(() => {
						if (column.search() !== element.value) {
							column
								.search(
									operator
										? operator + '___' + element.value
										: element.value
								)
								.draw();

							console.log(this.api().columns().search());
						}
					})
				);
			}
		}

		return element;
	};

	const setColumnSearchField = function () {
		const column = this;

		if (column.searchable()) {
			const data =
				column.fieldType() === 'select' ? column.fieldTypeData() : [];
			const input = createColumnSearchField(
				column,
				column.fieldType(),
				column.searchOperator(),
				data
			);

			column.header().append(input);
		}
	};

	const handleColumnSearchField = function () {
		this.api().columns().every(setColumnSearchField);
	};

	const datatable = new DataTables(target, {
		...{
			dom:
				"<'row'<'col-3'l>>" +
				"<'row dt-row'<'col-sm-12'tr>>" +
				"<'row'<'col-4'i><'col-8'p>>",
			serverSide: false,
			responsive: false,
			processing: false,
			pagingType: 'full_numbers',
			language: {
				info: 'Halaman _PAGE_ dari _PAGES_',
				lengthMenu: '_MENU_ ',
				search: '',
				searchPlaceholder: 'Pencarian',
				loadingRecords: 'Sedang memproses',
				infoFiltered: '',
				zeroRecords: '',
				emptyTable: 'Tidak ada data',
				processing: 'Sedang memproses',
				infoEmpty: '',
				paginate: {
					first: 'Awal',
					previous: 'Sebelumnya',
					next: 'Selanjutnya',
					last: 'Akhir',
				},
			},
			initComplete: options.handleColumnSearchField
				? handleColumnSearchField
				: null,
		},
		...options,
	});

	const setTableColor = () => {
		document
			.querySelectorAll('.dataTables_paginate .pagination')
			.forEach((dt) => {
				dt.classList.add('pagination-primary');
			});
	};
	setTableColor();
	datatable.on('draw', setTableColor);

	return datatable;
};

export default createDatatable;
