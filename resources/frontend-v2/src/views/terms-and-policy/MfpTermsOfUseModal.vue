<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import {modalController, IonContent} from "@ionic/vue"

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header
        title="Termos de Uso"
        @close-action="closeModal"
        @save-action="closeModal"
        :save-action-hidden="true"
    />
    <ion-content :fullscreen="false" class="ion-padding ion-margin-top">
        <div class="terms-container">
            <h3>1. Aceitação dos Termos</h3>
            <p>
                Ao usar o nosso aplicativo/site de finanças pessoais ("Finanças na Mão"), você concorda em cumprir e
                estar vinculado a estes Termos de Uso. Caso não concorde com os termos aqui estabelecidos, não deverá
                utilizar o Aplicativo/site.
            </p>

            <h3>2. Objetivo do Aplicativo</h3>
            <p>
                O Aplicativo/site tem como objetivo ajudar o usuário a gerenciar suas finanças pessoais, permitindo o
                cadastro de carteiras, cartões de crédito e o acompanhamento da sua saúde financeira, de acordo com o
                plano escolhido (Gratuito ou Pro).
            </p>

            <h3>3. Planos Disponíveis</h3>
            <h5>3.1. Plano Gratuito (Free)</h5>
            <p>
                O Plano Gratuito oferece funcionalidades limitadas. No Plano Gratuito, o usuário pode cadastrar uma (1)
                carteira e um (1) cartão de crédito. O Plano Gratuito não inclui acesso à ferramenta de saúde
                financeira. Este plano não possui qualquer custo para o usuário.
            </p>

            <h5>3.2. Plano Pro (Premium)</h5>
            <p>
                O Plano Pro oferece acesso completo a todas as funcionalidades do Aplicativo/site. No Plano Pro, não há
                limites de cadastro de carteiras e cartões de crédito. O usuário tem acesso irrestrito à ferramenta de
                saúde financeira. O custo do Plano Pro é de <strong>R$9,90 (nove reais e noventa centavos) por
                mês</strong>,
                com renovação automática a cada mês, salvo cancelamento por parte do usuário (conforme detalhado na
                Seção 5).
            </p>

            <h3>4. Cadastro de Usuário</h3>
            <p>
                Para utilizar o Aplicativo/site, o usuário deve criar uma conta fornecendo informações pessoais como
                nome, e-mail e, quando aplicável, informações de pagamento para o Plano Pro. O usuário é responsável
                por manter as informações de cadastro atualizadas e seguras.
            </p>

            <h3>5. Pagamento e Renovação Automática (Plano Pro)</h3>
            <h5>5.1. Cobrança</h5>
            <p>
                O valor de <strong>R$9,90 por mês</strong> será cobrado automaticamente do método de pagamento fornecido
                pelo usuário ao optar pelo Plano Pro. A cobrança será feita de forma recorrente até que o usuário
                solicite o cancelamento do plano. A intermediadora de pagamento é a Stripe.
            </p>

            <h5>5.2. Renovação Automática</h5>
            <p>
                O Plano Pro será renovado automaticamente a cada mês até o cancelamento pelo usuário. O usuário será
                notificado com antecedência sobre alterações no valor da assinatura.
            </p>

            <h5>5.3. Cancelamento</h5>
            <p>
                O usuário pode cancelar o Plano Pro a qualquer momento, acessando as configurações da sua conta no
                Aplicativo/site. Ao cancelar o Plano Pro, o usuário continuará a ter acesso às funcionalidades pagas
                até o final do período de cobrança atual. Após o término do período pago, o usuário será revertido
                automaticamente para o Plano Gratuito, perdendo o acesso às funcionalidades exclusivas do Plano Pro.
            </p>

            <h3>6. Política de Reembolso</h3>
            <p>
                Pagamentos para o Plano Pro não são reembolsáveis, exceto em casos de erro comprovado na cobrança. Ao
                cancelar o Plano Pro, o usuário continuará a ter acesso até o final do ciclo de cobrança, mas não será
                feito qualquer reembolso parcial pelo período não utilizado.
            </p>

            <h3>7. Modificações no Aplicativo e Planos</h3>
            <p>
                Reservamo-nos o direito de alterar, suspender ou descontinuar o Aplicativo/site (ou qualquer parte dele)
                a qualquer momento, com ou sem aviso prévio. Também podemos modificar os valores e as condições dos
                planos. Qualquer alteração no valor do Plano Pro será informada ao usuário com antecedência e será
                aplicada na próxima cobrança recorrente.
            </p>

            <h3>8. Limitações de Responsabilidade</h3>
            <p>
                O Aplicativo/site é fornecido "como está", sem garantias de qualquer tipo. Não nos responsabilizamos
                por quaisquer perdas ou danos, diretos ou indiretos, que possam resultar do uso do Aplicativo. O usuário
                é o único responsável pela gestão das suas finanças pessoais.
            </p>

            <h3>9. Proteção de Dados</h3>
            <p>
                O uso dos dados pessoais fornecidos pelo usuário está sujeito à nossa Política de Privacidade,
                que estabelece como coletamos, utilizamos, armazenamos e protegemos as informações pessoais do usuário,
                em conformidade com a Lei Geral de Proteção de Dados (LGPD).
            </p>

            <h3>10. Direitos de Propriedade Intelectual</h3>
            <p>
                Todos os direitos, títulos e interesses relativos ao Aplicativo/site, incluindo, sem limitação, o
                conteúdo, layout, design e código, são de nossa exclusiva propriedade ou licenciados para nós. O uso do
                Aplicativo/site não concede ao usuário qualquer direito de propriedade intelectual sobre o mesmo.
            </p>

            <h3>11. Alterações aos Termos de Uso</h3>
            <p>
                Reservamo-nos o direito de modificar estes Termos de Uso a qualquer momento. As alterações entrarão em
                vigor após a publicação da versão atualizada no Aplicativo. É responsabilidade do usuário verificar
                periodicamente os Termos de Uso para estar ciente de quaisquer mudanças.
            </p>

            <h3>12. Contato</h3>
            <p>
                Em caso de dúvidas ou problemas relacionados ao Aplicativo/site ou aos presentes Termos de Uso, o
                usuário pode entrar em contato conosco por meio do e-mail <strong>contato@financasnamao.com.br</strong>.
            </p>
        </div>
    </ion-content>
</template>

<style scoped>
.terms-container {
    font-family: Arial, sans-serif;
    line-height: 1.6;
}

.terms-container h3 {
    color: #0054e9;
    margin-top: 20px;
}

.terms-container h5 {
    color: #0054e9;
    margin-top: 15px;
}

.terms-container p {
    margin-bottom: 15px;
    text-align: justify;
}
</style>
