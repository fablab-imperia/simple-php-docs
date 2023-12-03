"use strict";

async function fetch_docs()
{
    return (await fetch(document.body.dataset.siteurl + "/lunr_data.json")).json();
}
(async() =>
    {
        let documents = await fetch_docs();
        
        let idx = lunr(function () {
            this.ref('id');
            this.field('title');
            this.field('content');
            documents.forEach(function (doc, id) {
                doc.id=id;
                this.add(doc)
            }, this)
        });

        function gen_result_html(res)
        {
            let html_data = "";
            for (const item of res)
            {
                let item_data = documents[item.ref];
                html_data += `
                <article class="card">
                <h3>${item_data.title}</h3>
                <a class="button pagebutton" href="${item_data.url}">Apri</a>
                </article>
                `;
            }
            return html_data;
        }

        document.getElementById("id_search_wiki")
        .addEventListener(
            "input",
            (ev)=>{
                let res = idx.search(
                    ev.target.value + "~1"
                );
                let container = document.getElementById("content_search_results");
                container.innerHTML = "";
                container.innerHTML = gen_result_html(res);
            }
        );
        
        document.getElementById("search_button_checkbox").addEventListener(
            "change",
            ()=>{
                let search_open_button = document.getElementById("id_search_wiki");
                search_open_button.value = "";
                document.getElementById("content_search_results").innerHTML = "";
            }
        );
    }
)();


