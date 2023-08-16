<template>
    <div class="base-container">
        <div class="glass mt-4">
            <div class="ms-5 me-5">
                <div class="row">
                    <div class="col-6 mt-5">
                        <mfp-title title="Sobre o projeto"/>
                        <divider/>
                    </div>
                </div>
                <p>
                    Olá, meu nome é <a href="https://www.jhon.dev.br" target="_blank" class="link">Jhon</a>
                    , desenvolvi esse projeto com o intuito de criar uma aplicação para gerenciar minhas finanças
                    pessoais. Antes desse projeto eu utilizava uma planilhas do excel para fazer todo o gerenciamento,
                    mas com o tempo percebi que a planilha não era mais suficiente para o que eu precisava, então decidi
                    criar uma aplicação web para gerenciar minhas finanças.
                </p>
                <p>
                    Com esse projeto eu aprendi muito principalmente sobre os frameworks Laravel e Vue.js, que são
                    frameworks muito poderosos e que facilitam muito o desenvolvimento de aplicações web. Também ampliei
                    meus conhecimentos sobre o PHP e o Javascript, que são linguagens que eu já tinha um conhecimento
                    prévio, mas que com esse projeto eu pude aprofundar mais ainda meus conhecimentos.
                </p>
                <p>
                    O projeto está disponível no <a :href="projectLink" target="_blank" class="link">github</a>, caso
                    queira contribuir com o projeto, fique a vontade para fazer um fork e enviar um pull request.
                </p>
                <div class="row mt-5">
                    <div class="col-6">
                        <mfp-title title="Como ver uma demo do projeto?"/>
                        <divider/>
                    </div>
                </div>
                <p>
                    Para ver uma demo do projeto, basta <a href="/login" target="_blank" class="link">clicar aqui</a>,
                    você será redirecionado para uma página de login, basta inserir os dados de acesso abaixo que você
                    será redirecionado para a página inicial do projeto.
                </p>
                <ul>
                    <li><strong>Usuário:</strong> {{ demoUser }}</li>
                    <li><strong>Senha:</strong> {{ demoPassword }}</li>
                </ul>
                <p>
                    Nesta demo, não será permitido a alteração de configurações do usuário (e-mail, senha, etc).
                    O bloqueio por quantidade de tentativas de login inválidas estão desabilitados.
                    Todos os os dados inseridos na demo serão excluídos diariamente, para que a demo esteja sempre limpa,
                    ou seja, todos os dias a demo voltará para seu estado pré-definido.
                </p>
                <div class="row mt-5">
                    <div class="col-6">
                        <mfp-title title="Sugestões e reportar erros"/>
                        <divider/>
                    </div>
                </div>
                <p>
                    Caso você tenha alguma sugestão ou tenha encontrado algum erro no projeto, você pode reportar
                    <a :href="openIssueLink" target="_blank" class="link">clicando aqui</a>.
                </p>
                <p>
                    Com sua ajuda, podemos melhorar cada vez mais o projeto.
                </p>
                <div class="row mt-5">
                    <div class="col-6">
                        <mfp-title title="Contato"/>
                        <divider/>
                    </div>
                    <p>
                        Caso queira entrar em contato comigo, você pode me enviar um e-mail para
                        <strong>{{ email }}</strong>.
                    </p>
                    <p>
                        Você também pode me encontrar nos demais canais:
                    </p>
                    <a class="btn btn-success me-3 mb-2" :href="linkedinLink" target="_blank">
                        <font-awesome-icon :icon="['fab', 'linkedin']" class="me-1"/>
                        Linkedin
                    </a>
                    <a class="btn btn-success me-3 mb-2" :href="githubLink" target="_blank">
                        <font-awesome-icon :icon="['fab', 'github']" class="me-1"/>
                        GitHub
                    </a>
                    <a class="btn btn-success me-3 mb-2" :href="mediumLink" target="_blank">
                        <font-awesome-icon :icon="['fab', 'medium']" class="me-1"/>
                        Medium
                    </a>
                    &nbsp;
                </div>
            </div>
        </div>
        &nbsp;
    </div>
</template>

<script>
    import MfpTitle from "../../components/TitleComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";

    export default {
        name: "AboutView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {Divider, MfpTitle},
        data() {
            return {
                projectLink: import.meta.env.VITE_LINK_PROJETC,
                openIssueLink: import.meta.env.VITE_LINK_OPEN_ISSUE,
                linkedinLink: import.meta.env.VITE_LINK_LINKEDIN,
                githubLink: import.meta.env.VITE_LINK_GITHUB,
                mediumLink: import.meta.env.VITE_LINK_MEDIUM,
                email: import.meta.env.VITE_EMAIL_CONTACT,
                demoUser: import.meta.env.VITE_DEMO_USER,
                demoPassword: import.meta.env.VITE_DEMO_PASSWORD
            }
        },
    }
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables";

    .link {
        color: $divider-component-color;
        text-decoration: none;
    }
    strong {
        color: $pop-up-success-color;
    }
</style>