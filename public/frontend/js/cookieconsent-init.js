// obtain plugin
var cc = initCookieConsent();

// run plugin with your configuration
cc.run({
    current_lang: 'id',
    autoclear_cookies: true,                   // default: false
    page_scripts: true,                        // default: false

    // mode: 'opt-in'                          // default: 'opt-in'; value: 'opt-in' or 'opt-out'
    // delay: 0,                               // default: 0
    auto_language: true,                     // default: null; could also be 'browser' or 'document'
    // autorun: true,                          // default: true
    // force_consent: false,                   // default: false
    // hide_from_bots: false,                  // default: false
    // remove_cookie_tables: false             // default: false
    // cookie_name: 'cc_cookie',               // default: 'cc_cookie'
    // cookie_expiration: 182,                 // default: 182 (days)
    // cookie_necessary_only_expiration: 182   // default: disabled
    // cookie_domain: location.hostname,       // default: current domain
    // cookie_path: '/',                       // default: root
    // cookie_same_site: 'Lax',                // default: 'Lax'
    // use_rfc_cookie: false,                  // default: false
    // revision: 0,                            // default: 0

    onFirstAction: function(user_preferences, cookie){
        // callback triggered only once
    },

    onAccept: function (cookie) {
        // ...
    },

    onChange: function (cookie, changed_preferences) {
        // ...
    },

    gui_options: {
        consent_modal: {
            layout: 'box',               // box/cloud/bar
            position: 'bottom left',     // bottom/middle/top + left/right/center
            transition: 'zoom',           // zoom/slide
            swap_buttons: true            // enable to invert buttons
        },
        settings_modal: {
            layout: 'bar',                 // box/bar
            // position: 'left',           // left/right
            transition: 'slide'            // zoom/slide
        }
    },

    languages: {
        'en1': {
            consent_modal: {
                title: 'We use cookies!',
                description: 'This website uses cookies to ensure its proper operation and tracking cookies to understand how you interact with it. <button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                primary_btn: {
                    text: 'Accept all',
                    role: 'accept_all'              // 'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Reject all',
                    role: 'accept_necessary'        // 'settings' or 'accept_necessary'
                }
            },
            settings_modal: {
                title: 'Cookie preferences',
                save_settings_btn: 'Save settings',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject all',
                close_btn_label: 'Close',
                cookie_table_headers: [
                    {col1: 'Name'},
                    {col2: 'Domain'},
                    {col3: 'Expiration'},
                    {col4: 'Description'}
                ],
                blocks: [
                    {
                        title: 'Cookie usage 📢',
                        description: 'I use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want. For more details relative to cookies and other sensitive data, please read the full <a href="https://telixcel.com/privacy-policy" class="cc-link">privacy policy</a>.'
                    }, {
                        title: 'Strictly necessary cookies',
                        description: 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true          // cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: 'Performance and Analytics cookies',
                        description: 'These cookies allow the website to remember the choices you have made in the past',
                        toggle: {
                            value: 'analytics',     // your cookie category
                            enabled: true,
                            readonly: false
                        },
                        // cookie_table: [             // list of all expected cookies
                        //     {
                        //         col1: '^_ga',       // match all cookies starting with "_ga"
                        //         col2: 'google.com',
                        //         col3: '2 years',
                        //         col4: 'description ...',
                        //         is_regex: true
                        //     },
                        //     {
                        //         col1: '_gid',
                        //         col2: 'google.com',
                        //         col3: '1 day',
                        //         col4: 'description ...',
                        //     }
                        // ]
                    }, {
                        title: 'Advertisement and Targeting cookies',
                        description: 'These cookies collect information about how you use the website, which pages you visited and which links you clicked on. All of the data is anonymized and cannot be used to identify you',
                        toggle: {
                            value: 'targeting',
                            enabled: true,
                            readonly: false
                        }
                    }, {
                        title: 'More information',
                        description: 'For any queries in relation to our policy on cookies and your choices, please <a class="cc-link" href="#yourcontactpage">contact us</a>.',
                    }
                ]
            }
        },
        'en': {
            consent_modal: {
                title: 'We care about your data',
                description: 'We"d love to use cookies to make your experience better. <button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                primary_btn: {
                    text: 'Ok',
                    role: 'accept_all'              // 'accept_selected' or 'accept_all'
                }
            },
            settings_modal: {
                title: 'Cookie preferences',
                save_settings_btn: 'Save settings',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject all',
                close_btn_label: 'Close',
                cookie_table_headers: [
                    {col1: 'Name'},
                    {col2: 'Domain'},
                    {col3: 'Expiration'},
                    {col4: 'Description'}
                ],
                blocks: [
                    {
                        title: 'Cookie usage 📢',
                        description: 'I use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want. For more details relative to cookies and other sensitive data, please read the full <a href="https://telixcel.com/privacy-policy" class="cc-link">privacy policy</a>.'
                    }, {
                        title: 'Strictly necessary cookies',
                        description: 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true          // cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: 'Performance and Analytics cookies',
                        description: 'These cookies allow the website to remember the choices you have made in the past',
                        toggle: {
                            value: 'analytics',     // your cookie category
                            enabled: true,
                            readonly: false
                        },
                        // cookie_table: [             // list of all expected cookies
                        //     {
                        //         col1: '^_ga',       // match all cookies starting with "_ga"
                        //         col2: 'google.com',
                        //         col3: '2 years',
                        //         col4: 'description ...',
                        //         is_regex: true
                        //     },
                        //     {
                        //         col1: '_gid',
                        //         col2: 'google.com',
                        //         col3: '1 day',
                        //         col4: 'description ...',
                        //     }
                        // ]
                    }, {
                        title: 'More information',
                        description: 'For any queries in relation to our policy on cookies and your choices, please <a class="cc-link" href="#yourcontactpage">contact us</a>.',
                    }
                ]
            }
        },
        'id': {
            consent_modal: {
                title: 'Kami menggunakan cookie',
                description: 'Situs ini menggunakan cookie untuk memudahkan pengoperasian dan pelacakan untuk memahami cara berinteraksi dengannya website. <button type="button" data-cc="c-settings" class="cc-link">Lihat pengaturan!</button>',
                primary_btn: {
                    text: 'Setuju semua',
                    role: 'accept_all'              // 'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Tolak semua',
                    role: 'accept_necessary'        // 'settings' or 'accept_necessary'
                }
            },
            settings_modal: {
                title: 'Cookie preferences',
                save_settings_btn: 'Simpan settings',
                accept_all_btn: 'Setuju semua',
                reject_all_btn: 'Tolak semua',
                close_btn_label: 'Tutup',
                cookie_table_headers: [
                    {col1: 'Name'},
                    {col2: 'Domain'},
                    {col3: 'Expiration'},
                    {col4: 'Description'}
                ],
                blocks: [
                    {
                        title: 'Penggunaan Cookie 📢',
                        description: 'Kami menggunakan cookie untuk memastikan fungsi dasar situs aplikasi web berjalan dengan baik dan untuk meningkatkan pengalaman dalam menggunakan situs web kami. Anda dapat memilih untuk setiap kategori cookie untuk mengaktifkan jika Anda mau. Untuk penjelasan lebih lanjut tentang cookie dan data sensitif lainnya, harap baca selengkapnya di <a href="https://telixcel.com/privacy-policy" class="cc-link">privacy policy</a>.'
                    }, {
                        title: 'Cookie yang diperlukan',
                        description: 'Cookie ini sangat penting agar situs web kami berfungsi dengan baik. Tanpa cookie ini, situs web tidak akan berfungsi dengan baik',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true          // cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: 'Cookie Performa dan Analitik',
                        description: 'Cookie ini menyimpan dan memungkinkan situs web mengingat pilihan yang telah Anda buat di masa lalu',
                        toggle: {
                            value: 'analytics',     // your cookie category
                            enabled: true,
                            readonly: false
                        },
                        cookie_table: [             // list of all expected cookies
                            {
                                col1: '^_ga',       // match all cookies starting with "_ga"
                                col2: 'google.com',
                                col3: '2 years',
                                col4: 'description ...',
                                is_regex: true
                            },
                            {
                                col1: '_gid',
                                col2: 'google.com',
                                col3: '1 day',
                                col4: 'description ...',
                            }
                        ]
                    }, {
                        title: 'Cookie Iklan dan Penargetan',
                        description: 'Cookie ini mengumpulkan informasi tentang cara penggunaan situs web, halaman mana yang telah dikunjungi, dan tautan mana yang telah di klik. Semua data dianonimkan dan tidak dapat digunakan untuk mengidentifikasi Anda',
                        toggle: {
                            value: 'targeting',
                            enabled: true,
                            readonly: false
                        }
                    }, {
                        title: 'Informasi lebih lanjut',
                        description: 'Jika ada pertanyaan lebih lanjut terkait dengan kebijakan kami tentang cookie, silakan <a class="cc-link" href="https://telixcel.com/#section-contact">hubungi kami</a>.',
                    }
                ]
            }
        }
    }
});
