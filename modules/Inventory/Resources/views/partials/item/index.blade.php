@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tbl-items tbody tr td:nth-child(2) a').each(function() {
                this.href = this.href.replace('common/items', 'inventory/items').replace('/edit', '');

                button = '<li><a href="' + this.href + '">{{ trans('general.show') }}</a></li>';

                $(this).parent().parent().find('td:last-child .dropdown-menu.dropdown-menu-right li:first').before(button);
            });
        });
    </script>
@endpush