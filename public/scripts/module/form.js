export function submit(form) {
    form.find('input, textarea').prop('readonly', true);
    form.find('[type="submit"], button[form="' + form.attr('id') + '"]').prop('disabled', true);
}