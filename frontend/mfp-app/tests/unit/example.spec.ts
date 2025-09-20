import { mount } from '@vue/test-utils';
import HomePage from '@/views/HomePage.vue';
import { describe, expect, test, vi } from 'vitest';
import { useRouter } from 'vue-router';
import { onIonViewWillEnter } from '@ionic/vue';

const push = vi.fn();
vi.mock('vue-router', () => ({
  useRouter: () => ({
    push,
  }),
}));

vi.mock('@ionic/vue', async () => {
  const actual = await vi.importActual('@ionic/vue');
  return {
    ...actual,
    onIonViewWillEnter: (callback: () => void) => {
      callback();
    },
  };
});

describe('HomePage.vue', () => {
  test('renders an empty page and redirects', async () => {
    const wrapper = mount(HomePage);
    expect(wrapper.text()).toBe('');
    expect(push).toHaveBeenCalledWith('/wallets');
  });
});
