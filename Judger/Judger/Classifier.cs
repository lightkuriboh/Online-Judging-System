using System;

namespace Judger
{
	public class Classifier
	{
		public string Reconize_name_of_Problem (string s) {
			int Len = s.Length;
			string Name = "";
			for (int i = Len - 1; i >= 0; i--)
				if (s [i] == ']') {
					for (int j = i - 1; j >= 0; j--) {
						if (s [j] != '[')
							Name = s [j] + Name;
						else
							break;
					}
					break;
				}
			return Name;
		}

		public string Reconize_ID_of_Problem (string s) {
			int Len = s.Length;
			string Name = "";
			int cnt = 0;
			for (int i = Len - 1; i >= 0; i--)
				if (s [i] == ']' && cnt == 1) {
					for (int j = i - 1; j >= 0; j--) {
						if (s [j] != '[')
							Name = s [j] + Name;
						else
							break;
					}
					break;
				} else if (s [i] == ']' && cnt == 0) cnt++;
			return Name;
		}

		public string Reconize_Language(string s) {
			string ans = "";
			for (int i = 0; i < s.Length; i++)
				if (s [i] == '.') {
					for (int j = i; j < s.Length; j++)
						ans += s [j];
					break;
				}
			return ans;
		}
	}
}

