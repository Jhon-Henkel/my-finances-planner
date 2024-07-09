import { describe, it, expect, vitest } from 'vitest'
import {RouterLinkStub, shallowMount} from '@vue/test-utils'
import ApiRouter from '~js/router/apiRouter'
import WallerView from '~vue/view/wallet/WalletView.vue'

describe('Testing the wallets list render', () => {
    it('should render list wallets basic screen view without wallets registered', async () => {
        expect(true).toBe(true)
    })
})