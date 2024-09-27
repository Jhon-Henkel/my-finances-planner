<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import {modalController, IonContent} from "@ionic/vue"

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header
        title="Politica de Privacidade"
        @close-action="closeModal"
        @save-action="closeModal"
        :save-action-hidden="true"
    />
    <ion-content :fullscreen="false" class="ion-padding ion-margin-top">
        <div class="privacy-policy-container">
            <h3>1. Introdução</h3>
            <p>
                Nós, Finanças na Mão, respeitamos a sua privacidade e estamos comprometidos em proteger as informações
                pessoais que você nos fornece. Esta Política de Privacidade descreve como coletamos, usamos, armazenamos
                e protegemos seus dados pessoais ao utilizar nosso aplicativo/site de finanças pessoais ("Finanças na
                Mão").
            </p>
            <p>
                Ao usar o Aplicativo/site, você concorda com a coleta e o uso de informações de acordo com esta Política
                de Privacidade.
            </p>

            <h3>2. Coleta de Informações</h3>
            <p>
                Coletamos informações para fornecer, manter e melhorar nosso Aplicativo/site, bem como para garantir uma
                experiência personalizada ao usuário. As informações que coletamos podem incluir:
            </p>

            <h5>2.1. Informações Pessoais</h5>
            <p>
                Dados de Cadastro: Quando você cria uma conta, podemos coletar informações como nome completo, e-mail e
                senha.
            </p>
            <p>
                Informações de Pagamento: Se você optar pelo Plano Pro, coletaremos informações necessárias para
                processar pagamentos, como detalhes do cartão de crédito/débito, e outras informações financeiras
                relevantes. Essas informações são processadas por provedores de pagamento terceirizados, e não
                armazenamos diretamente os dados completos de seu cartão.
            </p>

            <h5>2.2. Informações de Uso</h5>
            <p>
                Dados de Utilização: Coletamos informações sobre como você utiliza o Aplicativo, como interações com
                funcionalidades, data e hora de acesso, tipo de dispositivo, e sistema operacional.
            </p>
            <p>
                Informações Financeiras: Para ajudar na gestão das suas finanças, podemos coletar dados financeiros
                fornecidos por você, como o saldo de contas e cartões cadastrados no Aplicativo/site.
            </p>

            <h5>2.3. Informações de Dispositivo</h5>
            <p>
                Podemos coletar informações relacionadas ao dispositivo que você usa para acessar o Aplicativo/site,
                incluindo endereço IP, tipo de navegador, versão do sistema operacional e identificadores de dispositivo.
            </p>

            <h3>3. Uso das Informações</h3>
            <p>
                As informações coletadas são usadas para as seguintes finalidades:
            </p>
            <p>
                Fornecimento de Serviços: Usamos suas informações para fornecer e melhorar as funcionalidades do
                Aplicativo/site, incluindo o gerenciamento de carteiras, cartões e análise de saúde financeira
                (para usuários do Plano Pro).
            </p>
            <p>
                Processamento de Pagamentos: As informações financeiras são usadas para processar pagamentos
                relacionados ao Plano Pro e garantir a renovação automática de assinaturas.
            </p>
            <p>
                Comunicação: Podemos usar suas informações de contato para enviar notificações relacionadas ao
                Aplicativo/site, como atualizações, avisos de renovação de assinatura, mudanças de planos e informações
                promocionais (se autorizado).
            </p>
            <p>
                Personalização: As informações de uso podem ser usadas para personalizar sua experiência no
                Aplicativo/site e sugerir funcionalidades relevantes para suas necessidades financeiras.
            </p>
            <p>
                Melhoria de Serviços: Usamos os dados coletados para melhorar o desempenho do Aplicativo/site,
                desenvolver novas funcionalidades e identificar problemas técnicos.
            </p>

            <h3>4. Compartilhamento de Informações</h3>
            <p>
                Não vendemos, alugamos ou compartilhamos suas informações pessoais com terceiros, exceto nos seguintes
                casos:
            </p>
            <p>
                Provedores de Serviço: Compartilhamos informações com terceiros que nos ajudam a operar o
                Aplicativo/site, processar pagamentos ou fornecer suporte técnico, e apenas na medida necessária para a
                prestação desses serviços.
            </p>
            <p>
                Requisitos Legais: Podemos divulgar suas informações se exigido por lei ou em resposta a uma solicitação
                válida de autoridades governamentais.
            </p>
            <p>
                Proteção de Direitos: Podemos divulgar informações quando acreditarmos que seja necessário para proteger
                nossos direitos, sua segurança ou a segurança de outros usuários, investigar fraudes ou responder a
                solicitações governamentais.
            </p>

            <h3>5. Armazenamento e Proteção de Dados</h3>
            <p>
                Tomamos medidas de segurança apropriadas para proteger suas informações pessoais contra acesso não
                autorizado, alteração, divulgação ou destruição. Essas medidas incluem:
            </p>
            <p>
                Criptografia: Seus dados pessoais e financeiros são armazenados de forma segura, e as informações
                sensíveis, como detalhes de pagamento, são protegidas por criptografia durante a transmissão.
            </p>
            <p>
                Controles de Acesso: Apenas funcionários autorizados ou prestadores de serviços têm acesso aos seus
                dados pessoais, conforme necessário para desempenhar suas funções.
            </p>
            <p>
                As informações coletadas serão armazenadas pelo tempo que for necessário para fornecer os serviços
                solicitados ou conforme exigido por leis e regulamentações aplicáveis.
            </p>

            <h3>6. Direitos do Usuário</h3>
            <p>
                De acordo com a LGPD, você tem certos direitos em relação aos seus dados pessoais. Isso inclui:
            </p>
            <p>
                Acesso e Correção: Você pode acessar suas informações pessoais e solicitar a correção de dados
                incorretos ou incompletos.
            </p>
            <p>
                Exclusão de Dados: Você pode solicitar a exclusão de seus dados pessoais, exceto quando for necessário
                mantê-los para cumprir obrigações legais ou contratuais.
            </p>
            <p>
                Revogação de Consentimento: Caso tenha dado consentimento para o uso de suas informações, você pode
                revogá-lo a qualquer momento, embora isso possa impactar a continuidade do uso de certas funcionalidades
                do Aplicativo/site.
            </p>
            <p>
                Portabilidade de Dados: Você tem o direito de solicitar a transferência de seus dados pessoais para
                outro fornecedor de serviços, conforme aplicável.
            </p>
            <p>
                Para exercer seus direitos, você pode entrar em contato conosco por meio do e-mail
                contato@financasnamao.com.br.
            </p>

            <h3>7. Cookies e Tecnologias de Rastreamento</h3>
            <p>
                Nosso Aplicativo/site pode usar cookies e tecnologias semelhantes para coletar informações
                automaticamente sobre como você interage com o Aplicativo/site. Os cookies podem ser usados para lembrar
                suas preferências, personalizar o conteúdo e analisar o tráfego do aplicativo.
            </p>
            <p>
                Você pode optar por desativar os cookies através das configurações do seu navegador, mas isso pode
                afetar a funcionalidade do Aplicativo/site.
            </p>

            <h3>8. Transferência Internacional de Dados</h3>
            <p>
                Em alguns casos, as informações pessoais que coletamos podem ser transferidas e armazenadas em
                servidores localizados fora do seu país de residência. Tomamos todas as medidas razoáveis para garantir
                que seus dados sejam tratados com segurança, em conformidade com esta Política de Privacidade e as leis
                aplicáveis.
            </p>

            <h3>9. Alterações à Política de Privacidade</h3>
            <p>
                Reservamo-nos o direito de atualizar esta Política de Privacidade a qualquer momento. Quaisquer
                alterações entrarão em vigor imediatamente após a publicação da política revisada no Aplicativo/site. É
                de responsabilidade do usuário revisar periodicamente a Política de Privacidade para estar ciente de
                quaisquer atualizações.
            </p>

            <h3>10. Contato</h3>
            <p>
                Se você tiver dúvidas ou preocupações sobre esta Política de Privacidade ou sobre como suas informações
                pessoais são tratadas, entre em contato conosco por meio do e-mail contato@financasnamao.com.br.
            </p>

            <hr>
            Última atualização: 27/09/2024
        </div>
    </ion-content>
</template>

<style scoped>
.privacy-policy-container {
    font-family: Arial, sans-serif;
    line-height: 1.6;
}

.privacy-policy-container h3 {
    color: #0054e9;
    margin-top: 20px;
}

.privacy-policy-container h5 {
    color: #0054e9;
    margin-top: 15px;
}

.privacy-policy-container p {
    margin-bottom: 15px;
    text-align: justify;
}
</style>
