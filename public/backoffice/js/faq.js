/**
 * CMS (plugins summernote)
 */
$(function () {
    $('#tze_service_metiermanagerbundle_faq_translations_fr_faqtQuestion, #tze_service_metiermanagerbundle_faq_translations_fr_faqttResponse').summernote({
        lang: 'fr-FR',
        height: 200,       // set editor height
        minHeight: null,   // set minimum height of editor
        maxHeight: null    // set maximum height of editor
    });

    $('#tze_service_metiermanagerbundle_faq_translations_en_faqtQuestion, #tze_service_metiermanagerbundle_faq_translations_en_faqttResponse').summernote({
        height: 200,       // set editor height
        minHeight: null,   // set minimum height of editor
        maxHeight: null    // set maximum height of editor
    });
})
