#include <bits/stdc++.h>
using namespace std;
const int N = 51;
int ans[N], n, m, Jury_ans[N];
double a[N], p;
double res, Jury_res;
const double eps = 1e-3;
string test_id;

double power(double x, int b) {
    if (b == 1) return x;
    double tmp = power(x, (b >> 1));
    if (b % 2) return tmp * tmp * x;
    return tmp * tmp;
}

double OutPut, Jury_OutPut;

ifstream inpp;
string inp_link, out_link, parti_out_link;
int main()
{
    //freopen("inp.in", "r", stdin);
    ios_base::sync_with_stdio(false); cin.tie(0);
    //cin >> test_id;
    cin >> inp_link >> out_link >> parti_out_link;
    int cnt = 0;
    inpp.open(parti_out_link.c_str());
    int val;
    while (inpp >> val) {
        ans[++cnt] = val;

        if (ans[cnt] <= 0) {
            cout << 0;
            return 0;
        }
    }
    inpp.close();


    inpp.open(inp_link.c_str());
    inpp >> n >> m >> p;
    for (int i = 1; i <= n; i++) inpp >> a[i];
    inpp.close();
    if (cnt != n) {
        cout << 0; return 0;
    }

    inpp.open(out_link.c_str());
    for (int i = 1; i <= n; i++) inpp >> Jury_ans[i];

    for (int i = 1; i <= n; i++)
        OutPut += a[i] * (1.0 - power(1.0 - p, ans[i]));

    for (int i = 1; i <= n; i++)
        Jury_OutPut += a[i] * (1.0 - power(1.0 - p, ans[i]));
    inpp.close();
    if (abs(Jury_OutPut - OutPut) <= eps) cout << 1; else cout << 0;

    return 0;
}
