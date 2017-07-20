using System;
using System.IO;
using System.Threading;
using System.Diagnostics;
namespace Judger
{
	public class Judger
	{		
		Compile_and_Run Program;
		public string Test_address = "";
		public string submissionID = "";

		private void CreateResultFile () {
			string path_of_result = "/home/lightkuriboh/workspace/PHP/result/" + submissionID + ".txt";
			try {
				if (!File.Exists(path_of_result)) File.Create(path_of_result).Dispose();
				else 
					File.WriteAllText (path_of_result, "");
			} catch (Exception ex) {
				Console.WriteLine ("Error creating result file: {0}", ex.Message);
			}
		}

		private double Judge_With_Extend_Judging_Program (string path_to_program, string inpp, string outt) {
			Process Extend_Judging_Program = new Process ();
			Extend_Judging_Program.StartInfo.FileName = path_to_program;
			Extend_Judging_Program.StartInfo.RedirectStandardInput = true;
			Extend_Judging_Program.StartInfo.RedirectStandardOutput = true;
			Extend_Judging_Program.StartInfo.UseShellExecute = false;
			Extend_Judging_Program.StartInfo.CreateNoWindow = false;
			Extend_Judging_Program.Start ();

			//string Participant_OUTPUT = Program.Output;
			StreamWriter INPUT = Extend_Judging_Program.StandardInput;

			try {
				INPUT.WriteLine (inpp);
				INPUT.WriteLine (outt);
				//INPUT.WriteLine (Participant_OUTPUT);
				INPUT.WriteLine (GlobalConstant.destination + "output.out");
			} catch (Exception ex) {
				Console.WriteLine (ex.Message);
			}

			try {
				bool exited = Extend_Judging_Program.WaitForExit (Convert.ToInt32(GlobalConstant.TimeLimit * 1000.0));	
				if (!exited) {
					Extend_Judging_Program.Kill ();
					Extend_Judging_Program.Close ();
					Extend_Judging_Program.Dispose ();
				}

			} catch (Exception ex) {
				Console.WriteLine (ex.Message);
			}

			double final = 0.0;
			string response = "0.0";

			try {
				StreamReader OUTPUT = Extend_Judging_Program.StandardOutput;	
				response = OUTPUT.ReadToEnd ();
			} catch (Exception ex) {
				Console.WriteLine (ex.Message);
			}
			try {
				Extend_Judging_Program.Close ();
				Extend_Judging_Program.Dispose ();
			} catch {
			}
			//Console.WriteLine ("Response is: {0}", response);
			try {
				final = Convert.ToDouble (response);
				return final;
			} catch {
				return 0.0;
			}
				
		}

		private bool Compare_with(string Jury_output) {
			StreamReader Jury = new StreamReader (Jury_output);
			string Jury_line = "";
			try {
				Jury_line = Jury.ReadToEnd ();	
			} catch (Exception ex) {
				Console.WriteLine (ex.Message);
			}
			Jury.Close();
			string[] string_to_remove = new string [] {
				"\n",
				"  ",
			};
			try {
				foreach (string s in string_to_remove) {
					Jury_line = Jury_line.Replace (s, " ");
					Program.Output = Program.Output.Replace (s, " ");
				}
				for (int i = Jury_line.Length - 1; Jury_line[i] == ' ';)
					Jury_line = Jury_line.Remove(i);
			} catch (Exception ex) {
				Console.WriteLine ("ERROR: {0}\n", ex.Message);
			}

			return (Jury_line == Program.Output);
		}

		public void get_score (double score, bool successfully_compiled) {	
			try {
				StreamWriter res = new StreamWriter ("/home/lightkuriboh/workspace/PHP/result/" + submissionID + ".txt", true);

				if (successfully_compiled) {
					//if (Program.Error.Length > 0) res.WriteLine ("Error: " + Program.Error);
					//if (Program.ExitCode.Length > 0) res.WriteLine ("Exit Code: " + Program.ExitCode);
					//res.WriteLine ("Scored: " + score.ToString());
					res.WriteLine (score);
					res.Close ();
				} else {
					string Error = "Compile error!";
					res.WriteLine (Error);				
					res.Close ();
				}
			} catch (Exception ex) {
				Console.WriteLine (ex.Message);
			}
		}

		private void get_problem_config (string cfgFile) {
			StreamReader cfg = new StreamReader (cfgFile);
			string TL = cfg.ReadLine();
			GlobalConstant.TimeLimit = Convert.ToDouble (TL);
			string ML = cfg.ReadLine();
			GlobalConstant.MemoryLimit = Convert.ToDouble (ML);
		}

		void clear() {
			try {
				string[] myList = Directory.GetFiles (GlobalConstant.destination, "*.inp", SearchOption.AllDirectories);
				foreach (string link in myList) {
					File.Delete (link);
				}
			} catch (Exception ex) {
				Console.WriteLine (ex.Message);
			}
		}

		void Reset_Program() {
			Program.Output = "";
		}

		public void Process(string s, string extend, string Compiler) {		
			try {
				GlobalConstant.WA = false;

				string [] list_inp = Directory.GetFiles (Test_address, "*.inp", SearchOption.AllDirectories);
				string [] list_out = Directory.GetFiles (Test_address, "*.out", SearchOption.AllDirectories);
				string [] cfgFile = Directory.GetFiles (Test_address, "*.conf", SearchOption.AllDirectories);
				string [] Exist_Extend_Judging_Program = Directory.GetFiles (Test_address, "*.exe");
				string Compiled_program_extend = "";

				if (!(cfgFile == null || cfgFile.Length == 0)) get_problem_config (cfgFile[0]);

				int sz = list_inp.GetLength (0);
				if (sz < 1) return;
				double score = 0.0;
				double score_for_each_test = 1.0 * 100 / sz;

				Program = new Compile_and_Run ();
				Program.copy_participant_code (s, extend);
				Program.Compile_with (Compiler, extend);
				//Define type of program compiled 
				if (extend == ".cpp")
					Compiled_program_extend = ".out";
				//------------------------------------------------------------
				clear();
				for (int i = 0; i < sz; i++) {
					
					Reset_Program ();

					string inpp = list_inp [i], outt = list_out [i];
					Console.WriteLine ("Judging test: " + inpp);

					string input_copied = GlobalConstant.destination + "input.inp";
					try {
						File.Copy (list_inp [i], input_copied);
					} catch (Exception ex) {
						Console.WriteLine ("copy_error: {0}", ex.Message);
					}


					int RunningResult = Program.Run_participant_code_with (inpp, Compiled_program_extend);
					if (RunningResult == 0) {
						double Judging_Result = 0.0;
						if (!(Exist_Extend_Judging_Program == null || Exist_Extend_Judging_Program.Length == 0)) {
							Judging_Result = Judge_With_Extend_Judging_Program (Exist_Extend_Judging_Program [0], inpp, outt);								
						} else {
							if (Compare_with (outt))
								Judging_Result = 1.0;
						}		
						if (GlobalConstant.TLE == true) {
							Judging_Result = 0.0;
							Console.WriteLine ("TLE");
						} else
						if (Judging_Result > 0) {
							score += score_for_each_test * Judging_Result; 
						} else {
							GlobalConstant.WA = true;
							Console.WriteLine ("WA");
						}
						Console.WriteLine ("Score for this test: {0}", score_for_each_test * Judging_Result);
					} else if (RunningResult == 1) {
						get_score (score, false);
						Program.Delete_participant_file ();
						return;
					}
					File.Delete (input_copied);
				}

				Console.WriteLine ("JUDGED");
				Program.Delete_participant_file ();

				CreateResultFile ();
				get_score (score, true);

				Console.WriteLine (score);
			}
			catch (Exception ex) {
				Console.WriteLine (ex.Message);
			}

		}
	}
}

