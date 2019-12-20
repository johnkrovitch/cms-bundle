export default class Select2 {
    constructor() {
        $('.select2').select2({
            tags: true
        }).on('select2:select', function (event) {
            let data = event.params.data;
            let url = $(this).data('url');

            if (!url) {
                return;
            }
            let element = $(this);
            console.log('select2', event, data, url, data.id === data.text);

            if (data.id === data.text) {
                $.ajax({
                    url: url + '?value=' + data.text,
                    success: function (response) {
                        console.log('this', element, response, '<option value="' + response.id + '">' + response.name + '</option>');

                        element
                            // Find options set by select2
                            .find('option[value="' + data.text + '"]')
                            // Update with the new id
                            .attr('value', response.id,)
                            // Update text with new text
                            .text(response.name)
                        ;
                    }
                });
            }
        });
    }
}
